<?php

namespace App\Http\Controllers;

use App\Http\Requests\DTHRTH\CreateUpdateRequest;
use App\Models\DTHRTH;
use DataTables;
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

        return DataTables::of($datas)
            ->addColumn('action', function ($data) {
                return view('pages.dthrth.action', compact([
                    'data',
                ]));
            })
            ->make();
    }

    public function index()
    {
        return view('pages.dthrth.index');
    }

    public function create()
    {
        return view('pages.dthrth.form');
    }

    public function store(CreateUpdateRequest $request)
    {
        dd($request->all());
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load('05featuredemo.xlsx');

        return;

        $skpd = new DTHRTH;

        $skpd->skpd = $request->skpd;

        $skpd->save();
    }

    public function show(DTHRTH $skpd)
    {
        return $skpd;
    }

    public function edit(DTHRTH $skpd)
    {
        return view('pages.dthrth.form', compact([
            'skpd',
        ]));
    }

    public function update(CreateUpdateRequest $request, DTHRTH $skpd)
    {
        $skpd->skpd = $request->skpd;

        $skpd->save();
    }

    public function destroy(DTHRTH $skpd)
    {
        $skpd->delete();
    }
}
