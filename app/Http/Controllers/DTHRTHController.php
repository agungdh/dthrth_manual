<?php

namespace App\Http\Controllers;

use App\Http\Requests\DTHRTH\UploadRequest;
use App\Models\DTHRTH;
use App\Models\DTHRTHRinci;
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
        $datas = DTHRTHRinci::query();

        $datas = $datas->where('dthrth_id', $request->dthrth_id);

        return DataTables::of($datas)
            ->make();
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
                DTHRTHRinci::where('dthrth_id', $check->id)->delete();
                DTHRTH::where('id', $check->id)->delete();
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
        $dthrth->bulan_tahun = date_format(date_create($dthrth->bulan_tahun), 'm').'/'.date_format(date_create($dthrth->bulan_tahun), 'Y');
        $dthrth->uploaded_at = date_format(date_create($dthrth->uploaded_at), 'd-m-Y H:i:s');

        return view('pages.dthrth.lihat', compact([
            'dthrth',
        ]));
    }

    public function destroy(DTHRTH $dthrth)
    {
        DB::transaction(function () use ($dthrth) {
            DTHRTHRinci::where('dthrth_id', $dthrth->id)->delete();

            $dthrth->delete();
        });
    }
}
