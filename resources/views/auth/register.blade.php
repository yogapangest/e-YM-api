@extends('administrator.layouts.base')

@section('app')
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                        <div class="login-brand" style="margin-top: -40px;">
                            <img src="{{ asset('assets/img/e-ym/eym.png') }}" alt="logo" width="150">
                        </div>
                        <div class="card card-primary shadow-lg" style="margin-top: -20px;">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>

                            <div class="card-body">
                                <form id="RegisterForm" method="POST" class="needs-validation" novalidate=""
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                            tabindex="3" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in a valid email address.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input id="name" type="text" class="form-control" name="name"
                                                    tabindex="1" required>
                                                <div class="invalid-feedback">
                                                    Please fill in your name.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input id="username" type="text" class="form-control" name="username"
                                                    tabindex="2" required>
                                                <div class="invalid-feedback">
                                                    Please fill in your username.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <input id="alamat" type="text" class="form-control" name="alamat"
                                                    tabindex="1" required>
                                                <div class="invalid-feedback">
                                                    Please fill in your alamat.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="telephone">Telephone</label>
                                                <input id="telephone" type="text" class="form-control" name="telephone"
                                                    tabindex="2" required>
                                                <div class="invalid-feedback">
                                                    Please fill in your telephone.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input id="password" type="password" class="form-control" name="password"
                                                    tabindex="4" required>
                                                <div class="invalid-feedback">
                                                    Please fill in a password.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="confirm_password">Konfirmasi Password</label>
                                                <input id="confirm_password" type="password" class="form-control"
                                                    name="confirm_password" tabindex="5" required>
                                                <div class="invalid-feedback">
                                                    Please fill in the confirmation password.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="6">
                                            Register
                                        </button>
                                    </div>
                                </form>
                                <div class="mt-2 text-muted text-center">
                                    Don't have an account? <a href="{{ route('auth') }}">Login</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#RegisterForm').submit(function(event) {
                event.preventDefault();
                var email = $('#email').val();
                var name = $('#name').val();
                var username = $('#username').val();
                var alamat = $('#alamat').val();
                var telephone = $('#telephone').val();
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();

                var formData = new FormData(this);

                $.ajax({
                    url: '/api/register',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        console.log(data);
                        window.location.href = data.url;
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:',
                            error);
                    }
                });
            });
        });
    </script>
@endsection
