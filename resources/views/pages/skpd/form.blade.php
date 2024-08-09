@extends('layouts.default')

@section('content')
    <div class="card" x-data="form">
        <form @@submit.prevent="submit()">
            <fieldset :disabled="loading">
                <div class="card-header">
                    <h3 class="card-title">{{isset($skpd) ? 'Ubah' : 'Tambah'}} SKPD</h3>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>SKPD</label>
                        <input type="text" class="form-control" :class="hasAnyError(form) && 'is-invalid'" placeholder="SKPD" x-model="form.skpd.value">
                    </div>

                </div>
                <div class="card-footer">
                    <a href="/skpd"><button type="button" class="btn btn-secondary">Kembali</button></a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </fieldset>
        </form>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('form', () => ({
            loading: false,

            form: {
                skpd: {value: '', errors: []},
            },

            init() {
                var that = this

                @if(isset($skpd))
                axios.get('/skpd/{{$skpd->id}}')
                .then(function (response) {
                    let data = response.data

                    setFormData(that.form, data)
                })
                @endif
            },

            submit() {
                var that = this

                this.loading = true

                @if(isset($skpd))
                axios.put('/skpd/{{$skpd->id}}', formValue(this.form))
                @else
                axios.post('/skpd', formValue(this.form))
                @endif
                .then(function (response) {
                    resetFormErrors(that.form)

                    storeNotif({type: 'success', message: 'Berhasil {{isset($skpd) ? 'ubah' : 'tambah'}} data'})

                    window.location = '/skpd'
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
