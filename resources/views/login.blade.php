@extends('layouts.auth')

@section('content')
<div x-data="login">
    <div class="card">
        <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form @@submit.prevent="submit()">
            <div class="input-group mb-3">
            <input type="text" autocomplete="username" class="form-control" placeholder="Username" x-model="form.username">
            <div class="input-group-append">
                <div class="input-group-text">
                <span class="fas fa-user"></span>
                </div>
            </div>
            </div>
            <div class="input-group mb-3">
            <input type="password" autocomplete="current-password" class="form-control" placeholder="Password" x-model="form.password">
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
        </form>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('login', () => ({
            loading: false,

            form: {
                username: '',
                password: '',
            },

            async submit() {
                await axios.post('/login', this.form)
            },
        }))
    })
</script>
@endpush
