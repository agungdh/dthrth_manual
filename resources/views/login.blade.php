@extends('layouts.auth')

@section('content')
@verbatim
<div x-data="login">
    <div class="card">
        <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form @submit.prevent="submit()">
            <fieldset :disabled="loading">
                <div class="input-group mb-3">
                <input type="text" autocomplete="username" class="form-control" placeholder="Username" x-model="username">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                </div>
                </div>
                <div class="input-group mb-3">
                <input type="password" autocomplete="current-password" class="form-control" placeholder="Password" x-model="password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                </div>
                <div class="row">
                <!-- /.col -->
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
                </div>
            </fieldset>
        </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endverbatim
@endsection

@push('js')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('login', () => ({
        loading: false,

        username: '',
        password: '',

        submit() {
            var that = this

            this.loading = true

            axios.post('/login', {
                username: this.username,
                password: this.password,
            })
            .then(function (response) {
                window.location = '/'
            })
            .catch(function (error) {
                switch (error.response.status) {
                    case 422:
                        toastr.error('Username/Password Salah!')
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
