@extends('layouts.default')

@section('content')
@verbatim
<div class="card" x-data="form">
    <form @submit.prevent="submit()">
        <fieldset :disabled="loading">
            <div class="card-header">
                <h3 class="card-title" x-text="`${skpd ? 'Ubah' : 'Tambah'} SKPD`"></h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label>SKPD</label>
                    <input type="text" class="form-control" :class="hasAnyError(form, 'skpd') && 'is-invalid'" placeholder="SKPD" x-model="form.skpd.value">
                    <span class="error invalid-feedback" x-text="`${getFormError(form, 'skpd')}`"></span>
                </div>

            </div>
            <div class="card-footer">
                <a href="/skpd"><button type="button" class="btn btn-secondary">Kembali</button></a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </fieldset>
    </form>
</div>
@endverbatim
@endsection

@push('js')
<script>
var skpd = {{ isset($skpd) ? Js::from($skpd) : 'null' }}

document.addEventListener('alpine:init', () => {
    Alpine.data('form', () => ({
        loading: false,

        form: {
            skpd: {value: '', errors: []},
        },

        init() {
            var that = this

            if (skpd) {
                axios.get(`/skpd/${skpd.id}`)
                .then(function (response) {
                    let data = response.data

                    setFormData(that.form, data)
                })
            }
        },

        submit() {
            var that = this

            this.loading = true

            axios.post(skpd ? `/skpd/${skpd.id}` : '/skpd', formValue(this.form, skpd ? 'PUT' : 'POST'))
            .then(function (response) {
                resetFormErrors(that.form)

                storeNotif({type: 'success', message: `Berhasil ${skpd ? 'ubah' : 'tambah'} data`})

                window.location = '/skpd'
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
