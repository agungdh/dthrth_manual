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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.skpd.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.skpd.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUpdateRequest $request)
    {
        $skpd = new Skpd;

        $skpd->skpd = $request->skpd;

        $skpd->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
