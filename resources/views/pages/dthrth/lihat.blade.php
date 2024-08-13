@extends('layouts.default')

@section('content')
<div class="card" x-data="form">
    <div class="card-header">
        <h3 class="card-title">DTHRTH</h3>
    </div>
    <div class="card-body">
        <form @submit.prevent="submit()">
            <fieldset :disabled="loading">
                <div class="row mb-3">
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

                    <div class="col-12">
                        <div class="form-group">
                            <label>Berkas</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" :class="hasAnyError(form, 'berkas') && 'is-invalid'" placeholder="Berkas" id="berkas">
                                <span class="error invalid-feedback" x-text="`${getFormError(form, 'berkas')}`"></span>
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </fieldset>
        </form>

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

document.addEventListener('alpine:init', () => {
    Alpine.data('form', () => ({
        loading: false,

        form: {
            bulan: {value: dthrth.bulan, errors: []},
            tahun: {value: dthrth.tahun, errors: []},
            berkas: {value: '', errors: []},
        },

        async check() {
            let response = await axios.post('/dthrth/check', {
                bulan: this.form.bulan.value,
                tahun: this.form.tahun.value,
            })

            if (response.data) {
                let result = await Swal.fire({
                    title: "Data sudah ada",
                    text: "Anda yakin ingin mengganti data yang sudah ada ?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, ganti data"
                })

                return result.isConfirmed
            }

            return true
        },

        async submit() {
            if (await this.check()) {
                var that = this

                this.loading = true

                let form = formValue(this.form, 'POST')

                form.set('berkas', document.getElementById('berkas').files[0])

                axios.post('/dthrth', form)
                .then(function (response) {
                    resetFormErrors(that.form)

                    storeNotif({type: 'success', message: `Berhasil upload data`})

                    window.location = `/dthrth/${response.data.id}`
                })
                .catch(function (error) {
                    switch (error.response.status) {
                        case 422:
                            resetFormErrors(that.form)

                            setFormError(that.form, error)
                            break;

                        default:
                            break;
                    }
                })
                .finally(function () {
                    that.loading = false
                });
            }
        },
    }))
})


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
