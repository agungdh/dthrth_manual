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

                <div class="form-group">
                    <label>Berkas</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" :class="hasAnyError(form) && 'is-invalid'" placeholder="Berkas" x-model="form.berkas.value">
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

            if (dthrth) {
                httpForm = axios.put(`/dthrth/${dthrth.id}`, formValue(this.form))
            } else {
                httpForm = axios.post('/dthrth', formValue(this.form))
            }

            httpForm.then(function (response) {
                resetFormErrors(that.form)

                // storeNotif({type: 'success', message: `Berhasil ${dthrth ? 'ubah' : 'tambah'} data`})

                // window.location = '/dthrth'

                console.log('form')
            })
            .catch(function (error) {
                switch (error.response.status) {
                    case 422:
                        resetFormErrors(that.form)

                        let errors = error.response.data.errors

                        for (const key in errors) {
                            const element = errors[key];

                            that.form[key].errors = element
                        }
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
