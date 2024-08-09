@extends('layouts.default')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">SKPD</h3>
        </div>
        <div class="card-body">
            <table id="tabel" class="table table-sm table-striped table-hover" style="width: 100%">
                <thead>
                    <tr>
                        @for ($i = 1; $i <= 50; $i++)
                        <th>SKPD</th>
                        @endfor
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(function() {
        $('#tabel').DataTable( {
            scrollX: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: `/skpd/datatable`,
                type: 'POST'
            },
            columns: [
                @for ($i = 1; $i <= 50; $i++)
              {data: 'skpd', name: 'skpd'},
              @endfor
              {data: 'action'},
          ],
        } );
    });
</script>
@endpush
