<?php

namespace App\Http\Controllers;

use App\Http\Requests\Skpd\CreateUpdateRequest;
use App\Models\Skpd;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class SkpdController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    public function datatable(Request $request)
    {
        $datas = Skpd::query();

        return DataTables::of($datas)
            ->addColumn('action', function ($data) {
                return view('pages.skpd.action', compact([
                    'data',
                ]));
            })
            ->make();
    }

    public function index()
    {
        return view('pages.skpd.index');
    }

    public function create()
    {
        return view('pages.skpd.form');
    }

    public function store(CreateUpdateRequest $request)
    {
        $skpd = new Skpd;

        $skpd->skpd = $request->skpd;

        $skpd->save();
    }

    public function show(Skpd $skpd)
    {
        return $skpd;
    }

    public function edit(Skpd $skpd)
    {
        return view('pages.skpd.form', compact([
            'skpd',
        ]));
    }

    public function update(CreateUpdateRequest $request, Skpd $skpd)
    {
        $skpd->skpd = $request->skpd;

        $skpd->save();
    }

    public function destroy(Skpd $skpd)
    {
        $skpd->delete();
    }
}
