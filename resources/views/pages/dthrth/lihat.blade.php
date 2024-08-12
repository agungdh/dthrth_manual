@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DTHRTH</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Bulan Tahun</label>
                    <input type="text" class="form-control" id="bulan_tahun" readonly>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Tanggal Upload</label>
                    <input type="text" class="form-control" id="tanggal_upload" readonly>
                </div>
            </div>
        </div>

        <table id="tabel" class="table table-sm table-striped table-hover" style="width: 100%">
            <thead>
                <tr>
                    <th>no</th>
                    <th>no_spm</th>
                    <th>nilai_spm</th>
                    <th>tanggal_spm</th>
                    <th>no_sp2d</th>
                    <th>nilai_sp2d</th>
                    <th>tanggal_sp2d</th>
                    <th>kode_akun_belanja</th>
                    <th>kode_akun_pajak</th>
                    <th>ppn</th>
                    <th>pph21</th>
                    <th>pph22</th>
                    <th>pph23</th>
                    <th>pph4_2</th>
                    <th>jumlah</th>
                    <th>npwp</th>
                    <th>nama</th>
                    <th>kode_billing</th>
                    <th>ntpn</th>
                    <th>ket</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="card-footer">
        <a href="/dthrth"><button type="button" class="btn btn-secondary">Kembali</button></a>
    </div>
</div>
@endsection

@push('js')
<script>
var dthrth = {{ Js::from($dthrth) }}

$(function() {
    $("#bulan_tahun").val(dthrth.bulan_tahun)
    $("#tanggal_upload").val(dthrth.uploaded_at)

    $('#tabel').DataTable( {
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `/dthrth/datatableLihat`,
            type: 'POST',
            data: function (d) {
                d.dthrth_id = dthrth.id;
            }
        },
        columns: [
            {data: 'no', name: 'no'},
            {data: 'no_spm', name: 'no_spm'},
            {data: 'nilai_spm', name: 'nilai_spm'},
            {data: 'tanggal_spm', name: 'tanggal_spm'},
            {data: 'no_sp2d', name: 'no_sp2d'},
            {data: 'nilai_sp2d', name: 'nilai_sp2d'},
            {data: 'tanggal_sp2d', name: 'tanggal_sp2d'},
            {data: 'kode_akun_belanja', name: 'kode_akun_belanja'},
            {data: 'kode_akun_pajak', name: 'kode_akun_pajak'},
            {data: 'ppn', name: 'ppn'},
            {data: 'pph21', name: 'pph21'},
            {data: 'pph22', name: 'pph22'},
            {data: 'pph23', name: 'pph23'},
            {data: 'pph4_2', name: 'pph4_2'},
            {data: 'jumlah', name: 'jumlah'},
            {data: 'npwp', name: 'npwp'},
            {data: 'nama', name: 'nama'},
            {data: 'kode_billing', name: 'kode_billing'},
            {data: 'ntpn', name: 'ntpn'},
            {data: 'ket', name: 'ket'},
        ],
    } );
});
</script>
@endpush
