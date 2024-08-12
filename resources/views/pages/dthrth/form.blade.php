@extends('layouts.default')

@section('content')
@verbatim
<div class="card" x-data="form">
    <form @submit.prevent="submit()">
        <fieldset :disabled="loading">
            <div class="card-header">
                <h3 class="card-title" x-text="`${dthrth ? 'Ubah' : 'Tambah'} DTHRTH`"></h3>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Bulan</label>
                            <input type="text" class="form-control" :class="hasAnyError(form, 'bulan') && 'is-invalid'" placeholder="Bulan" x-model="form.bulan.value">
                            <span class="error invalid-feedback" x-text="`${getFormError(form, 'bulan')}`"></span>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="text" class="form-control" :class="hasAnyError(form, 'tahun') && 'is-invalid'" placeholder="Tahun" x-model="form.tahun.value">
                            <span class="error invalid-feedback" x-text="`${getFormError(form, 'tahun')}`"></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Berkas</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" :class="hasAnyError(form, 'berkas') && 'is-invalid'" placeholder="Berkas" id="berkas">
                        <span class="error invalid-feedback" x-text="`${getFormError(form, 'berkas')}`"></span>
                        <label class="custom-file-label">Choose file</label>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="/dthrth"><button type="button" class="btn btn-secondary">Kembali</button></a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </fieldset>
    </form>
</div>
@endverbatim
@endsection

@push('js')
<script>
var dthrth = {{ isset($dthrth) ? Js::from($dthrth) : 'null' }}

document.addEventListener('alpine:init', () => {
    Alpine.data('form', () => ({
        loading: false,

        form: {
            bulan: {value: '', errors: []},
            tahun: {value: '', errors: []},
            berkas: {value: '', errors: []},
        },

        init() {
            var that = this

            if (dthrth) {
                axios.get(`/dthrth/${dthrth.id}`)
                .then(function (response) {
                    let data = response.data

                    setFormData(that.form, data)
                })
            }
        },


        submit() {
            var that = this

            this.loading = true

            let form = formValue(this.form, dthrth ? 'PUT' : 'POST')

            form.set('berkas', document.getElementById('berkas').files[0])

            axios.post(dthrth ? `/dthrth/${dthrth.id}` : '/dthrth', form)
            .then(function (response) {
                resetFormErrors(that.form)

                // storeNotif({type: 'success', message: `Berhasil ${dthrth ? 'ubah' : 'tambah'} data`})

                // window.location = '/dthrth'

                console.log('form')
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
        },
    }))
})
</script>
@endpush
