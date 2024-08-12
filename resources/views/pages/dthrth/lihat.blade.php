@extends('layouts.default')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DTHRTH</h3>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <a href="/dthrth/create"><button class="btn btn-sm btn-success">Upload</button></a>
        </div>
        <table id="tabel" class="table table-sm table-striped table-hover" style="width: 100%">
            <thead>
                <tr>
                    <th>Bulan/Tahun</th>
                    <th>Tanggal Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
function hapusData(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/dthrth/${id}`).then(function (response) {
                toastr.success('Berhasil hapus data')

                $('#tabel').DataTable().ajax.reload()
            })
        }
    });
}

$(function() {
    $('#tabel').DataTable( {
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: `/dthrth/datatable`,
            type: 'POST'
        },
        columns: [
            {data: 'bulan_tahun', name: 'bulan_tahun'},
            {data: 'uploaded_at', name: 'uploaded_at'},
            {data: 'action', orderable: false, searchable: false},
        ],
    } );
});
</script>
@endpush
