<?php

namespace App\Http\Controllers;

use App\Http\Requests\DTHRTH\UploadRequest;
use App\Models\DTHRTH;
use App\Models\DTHRTHRinci;
use App\Models\DTHRTHRiwayat;
use App\Models\DTHRTHRiwayatRinci;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class DTHRTHController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function datatable(Request $request)
    {
        $datas = DTHRTH::query();

        $datas = $datas->where('skpd_id', $request->skpd_id);

        return DataTables::of($datas)
            ->editColumn('bulan_tahun', function ($data) {
                return date_format(date_create($data->bulan_tahun), 'm').'/'.date_format(date_create($data->bulan_tahun), 'Y');
            })
            ->editColumn('uploaded_at', function ($data) {
                return date_format(date_create($data->uploaded_at), 'd-m-Y H:i:s');
            })
            ->addColumn('action', function ($data) {
                return view('pages.dthrth.action', compact([
                    'data',
                ]));
            })
            ->make();
    }

    public function datatableLihat(Request $request)
    {
        $datas = DTHRTHRinci::from((new DTHRTHRinci)->getTable().' as r');

        $datas = $datas->select('r.*', 'dr.id as duplikat');

        // Duplikat
        $datas = $datas->leftJoin(DB::raw('(
            SELECT id
            FROM dthrth_rincis
            WHERE (ntpn IN (
                SELECT ntpn
                FROM dthrth_rincis
                GROUP BY ntpn
                HAVING COUNT(*) > 1
            ) or kode_billing IN (
                SELECT kode_billing
                FROM dthrth_rincis
                GROUP BY kode_billing
                HAVING COUNT(*) > 1
            ))
        ) as dr'), 'dr.id', '=', 'r.id');

        if ($request->duplikasi) {
            if ($request->duplikasi == 'ya') {
                $datas = $datas->whereNotNull('dr.id');
            }
            if ($request->duplikasi == 'tidak') {
                $datas = $datas->whereNull('dr.id');
            }
        }

        $datas = $datas->where('r.dthrth_id', $request->dthrth_id);

        return DataTables::of($datas)
            ->make();
    }

    public function listDuped(Request $request)
    {
        $dthrthSource = DTHRTHRinci::with('dthrth.skpd')->findOrFail($request->excluded_id);
        $dthrth = $dthrthSource->dthrth;

        $dthrth->bulan = (int) date_format(date_create($dthrth->bulan_tahun), 'm');
        $dthrth->tahun = (int) date_format(date_create($dthrth->bulan_tahun), 'Y');
        $dthrth->bulan_tahun = date_format(date_create($dthrth->bulan_tahun), 'm').'/'.date_format(date_create($dthrth->bulan_tahun), 'Y');
        $dthrth->uploaded_at = date_format(date_create($dthrth->uploaded_at), 'd-m-Y H:i:s');

        $datas = DTHRTHRinci::with('dthrth.skpd')
            ->where(function ($query) use ($request) {
                $query->orWhere('ntpn', $request->ntpn)
                    ->orWhere('kode_billing', $request->kode_billing);
            })
            ->where('id', '!=', $request->excluded_id)
            ->get();

        $datas->each(function ($data) {
            $dthrth = $data->dthrth;

            $dthrth->bulan = (int) date_format(date_create($dthrth->bulan_tahun), 'm');
            $dthrth->tahun = (int) date_format(date_create($dthrth->bulan_tahun), 'Y');
            $dthrth->bulan_tahun = date_format(date_create($dthrth->bulan_tahun), 'm').'/'.date_format(date_create($dthrth->bulan_tahun), 'Y');
            $dthrth->uploaded_at = date_format(date_create($dthrth->uploaded_at), 'd-m-Y H:i:s');
        });

        return [
            'dthrth' => $dthrthSource,
            'dupedList' => $datas,
        ];
    }

    public function checkDuplikat(Request $request)
    {
        $ntpns = DB::table(DB::raw('(
            SELECT ntpn
            FROM dthrth_rincis
            WHERE ntpn IN (
                SELECT ntpn
                FROM dthrth_rincis
                GROUP BY ntpn
                HAVING COUNT(*) > 1
            )
        ) as tbl'));

        $ntpns = $ntpns->whereIn('ntpn', $request->ntpns);

        $dupedNtpns = $ntpns->select('ntpn')->distinct()->pluck('ntpn');

        $kodeBillings = DB::table(DB::raw('(
            SELECT kode_billing
            FROM dthrth_rincis
            WHERE kode_billing IN (
                SELECT kode_billing
                FROM dthrth_rincis
                GROUP BY kode_billing
                HAVING COUNT(*) > 1
            )
        ) as tbl'));

        $kodeBillings = $kodeBillings->whereIn('kode_billing', $request->kode_billings);

        $dupedKodeBillings = $kodeBillings->select('kode_billing')->distinct()->pluck('kode_billing');

        return compact([
            'dupedNtpns',
            'dupedKodeBillings',
        ]);
    }

    public function check(Request $request)
    {
        $checkWhere = [
            'skpd_id' => auth()->user()->operator->skpd_id,
            'bulan_tahun' => "{$request->tahun}-{$request->bulan}-01",
        ];
        $check = DTHRTH::where($checkWhere)->first();

        return $check ?: null;
    }

    public function index()
    {
        return view('pages.dthrth.index');
    }

    public function create()
    {
        return view('pages.dthrth.form');
    }

    public function store(UploadRequest $request)
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($request->berkas->getPathName());

        $worksheet = $spreadsheet->getActiveSheet();

        return DB::transaction(function () use ($request, $worksheet) {
            $checkWhere = [
                'skpd_id' => auth()->user()->operator->skpd_id,
                'bulan_tahun' => "{$request->tahun}-{$request->bulan}-01",
            ];
            $check = DTHRTH::where($checkWhere)->first();
            if ($check) {
                $this->moveToRiwayat($check, 'upload');
            }

            $dthrth = new DTHRTH;

            $dthrth->skpd_id = $checkWhere['skpd_id'];
            $dthrth->bulan_tahun = $checkWhere['bulan_tahun'];
            $dthrth->uploaded_at = now();

            $dthrth->save();

            $arrDatas = [];
            $rowIterator = $worksheet->getRowIterator();
            foreach ($rowIterator as $row) {
                if ($row->getRowIndex() > 1) {

                    $columnIterator = $row->getCellIterator();

                    $sheetArrDatas = [];
                    foreach ($columnIterator as $cell) {
                        switch ($cell->getColumn()) {
                            case 'D':
                            case 'G':
                                $sheetArrDatas[$cell->getColumn()] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cell->getFormattedValue());
                                break;

                            default:
                                $sheetArrDatas[$cell->getColumn()] = $cell->getFormattedValue();
                                break;
                        }
                    }
                    $arrDatas[] = $sheetArrDatas;
                }
            }

            foreach ($arrDatas as $data) {
                $dthrth_rinci = new DTHRTHRinci;

                $dthrth_rinci->dthrth_id = $dthrth->id;

                $i = 'A';
                $dthrth_rinci->no = $data[$i++];
                $dthrth_rinci->no_spm = $data[$i++];
                $dthrth_rinci->nilai_spm = $data[$i++];
                $dthrth_rinci->tanggal_spm = $data[$i++]->format('Y-m-d');
                $dthrth_rinci->no_sp2d = $data[$i++];
                $dthrth_rinci->nilai_sp2d = $data[$i++];
                $dthrth_rinci->tanggal_sp2d = $data[$i++]->format('Y-m-d');
                $dthrth_rinci->kode_akun_belanja = $data[$i++];
                $dthrth_rinci->kode_akun_pajak = $data[$i++];
                $dthrth_rinci->ppn = $data[$i++] ?: null;
                $dthrth_rinci->pph21 = $data[$i++] ?: null;
                $dthrth_rinci->pph22 = $data[$i++] ?: null;
                $dthrth_rinci->pph23 = $data[$i++] ?: null;
                $dthrth_rinci->pph4_2 = $data[$i++] ?: null;
                $dthrth_rinci->jumlah = $data[$i++] ?: null;
                $dthrth_rinci->npwp = $data[$i++];
                $dthrth_rinci->nama = $data[$i++];
                $dthrth_rinci->kode_billing = $data[$i++];
                $dthrth_rinci->ntpn = $data[$i++];
                $dthrth_rinci->ket = $data[$i++];

                $dthrth_rinci->save();
            }

            return $dthrth;
        });
    }

    public function show(DTHRTH $dthrth)
    {
        $dthrth->bulan = (int) date_format(date_create($dthrth->bulan_tahun), 'm');
        $dthrth->tahun = (int) date_format(date_create($dthrth->bulan_tahun), 'Y');
        $dthrth->bulan_tahun = date_format(date_create($dthrth->bulan_tahun), 'm').'/'.date_format(date_create($dthrth->bulan_tahun), 'Y');
        $dthrth->uploaded_at = date_format(date_create($dthrth->uploaded_at), 'd-m-Y H:i:s');

        return view('pages.dthrth.lihat', compact([
            'dthrth',
        ]));
    }

    public function destroy(DTHRTH $dthrth)
    {
        DB::transaction(function () use ($dthrth) {
            $this->moveToRiwayat($dthrth, 'delete');
        });
    }

    private function moveToRiwayat(DTHRTH $dthrth, string $action)
    {
        $dthrth->load('rincis');

        $dthrthRiwayat = new DTHRTHRiwayat;

        $dthrthRiwayat->skpd_id = $dthrth->skpd_id;
        $dthrthRiwayat->bulan_tahun = $dthrth->bulan_tahun;
        $dthrthRiwayat->uploaded_at = $dthrth->uploaded_at;
        $dthrthRiwayat->archieved_at = now();
        $dthrthRiwayat->archieved_for = $action;

        $dthrthRiwayat->save();

        $dthrth->rincis->each(function ($rinci) use ($dthrthRiwayat) {
            $dthrthRiwayatRincis = new DTHRTHRiwayatRinci;

            $dthrthRiwayatRincis->dthrth_riwayat_id = $dthrthRiwayat->id;
            $dthrthRiwayatRincis->no = $rinci->no;
            $dthrthRiwayatRincis->no_spm = $rinci->no_spm;
            $dthrthRiwayatRincis->nilai_spm = $rinci->nilai_spm;
            $dthrthRiwayatRincis->tanggal_spm = $rinci->tanggal_spm;
            $dthrthRiwayatRincis->no_sp2d = $rinci->no_sp2d;
            $dthrthRiwayatRincis->nilai_sp2d = $rinci->nilai_sp2d;
            $dthrthRiwayatRincis->tanggal_sp2d = $rinci->tanggal_sp2d;
            $dthrthRiwayatRincis->kode_akun_belanja = $rinci->kode_akun_belanja;
            $dthrthRiwayatRincis->kode_akun_pajak = $rinci->kode_akun_pajak;
            $dthrthRiwayatRincis->ppn = $rinci->ppn;
            $dthrthRiwayatRincis->pph21 = $rinci->pph21;
            $dthrthRiwayatRincis->pph22 = $rinci->pph22;
            $dthrthRiwayatRincis->pph23 = $rinci->pph23;
            $dthrthRiwayatRincis->pph4_2 = $rinci->pph4_2;
            $dthrthRiwayatRincis->jumlah = $rinci->jumlah;
            $dthrthRiwayatRincis->npwp = $rinci->npwp;
            $dthrthRiwayatRincis->nama = $rinci->nama;
            $dthrthRiwayatRincis->kode_billing = $rinci->kode_billing;
            $dthrthRiwayatRincis->ntpn = $rinci->ntpn;
            $dthrthRiwayatRincis->ket = $rinci->ket;

            $dthrthRiwayatRincis->save();
        });

        DTHRTHRinci::where('dthrth_id', $dthrth->id)->delete();

        $dthrth->delete();
    }
}
