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
                                <form method="POST" action="{{ route('registration') }}" class="needs-validation"
                                    novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                            tabindex="3" required>
                                        <div class="invalid-feedback">
                                            Please fill in a valid email address.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input id="name" type="text" class="form-control" name="name"
                                                    tabindex="1" required autofocus>
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
                                                    tabindex="1" required autofocus>
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
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                                <input id="password_confirmation" type="password" class="form-control"
                                                    name="password_confirmation" tabindex="5" required>
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
@endsection
