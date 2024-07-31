@extends('administrator.layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah User</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" id="dataDonatur" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        tabindex="3" required autofocus>
                                    @error('email')
                                        <div id="email" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                tabindex="1" required>
                                            @error('name')
                                                <div id="name" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input id="username" type="text"
                                                class="form-control @error('username') is-invalid @enderror" name="username"
                                                tabindex="2" required>
                                            @error('username')
                                                <div id="username" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input id="alamat" type="text"
                                                class="form-control @error('alamat') is-invalid @enderror" name="alamat"
                                                tabindex="1" required>
                                            @error('alamat')
                                                <div id="alamat" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="telephone">Telephone</label>
                                            <input id="telephone" type="text"
                                                class="form-control @error('telephone') is-invalid @enderror"
                                                name="telephone" tabindex="2" required>
                                            @error('telephone')
                                                <div id="telephone" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                tabindex="4" required>
                                            @error('password')
                                                <div id="password" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="confirm_password">Konfirmasi Password</label>
                                            <input id="confirm_password" type="password"
                                                class="form-control @error('confirm_password') is-invalid @enderror"
                                                name="confirm_password" tabindex="5" required>
                                            @error('confirm_password')
                                                <div id="confirm_password" class="form-text">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah User
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script>
        $(document).ready(function() {
            $('#dataDonatur').submit(function(event) {
                event.preventDefault();

                // Ambil nilai dari setiap input
                var email = $('#email').val();
                var name = $('#name').val();
                var username = $('#username').val();
                var alamat = $('#alamat').val();
                var telephone = $('#telephone').val();
                var password = $('#password').val();
                var confirmPassword = $('#confirm_password').val();

                // Validasi form
                let isValid = true;
                let errorMessage = '';

                if (!email) {
                    isValid = false;
                    errorMessage = 'Email harus diisi';
                } else if (!name) {
                    isValid = false;
                    errorMessage = 'Nama harus diisi';
                } else if (!username) {
                    isValid = false;
                    errorMessage = 'Username harus diisi';
                } else if (!alamat) {
                    isValid = false;
                    errorMessage = 'Alamat harus diisi';
                } else if (!telephone) {
                    isValid = false;
                    errorMessage = 'Telepon harus diisi';
                } else if (!password) {
                    isValid = false;
                    errorMessage = 'Password harus diisi';
                } else if (password !== confirmPassword) {
                    isValid = false;
                    errorMessage = 'Password dan konfirmasi password tidak cocok';
                }

                // Jika validasi gagal, tampilkan SweetAlert
                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorMessage,
                        confirmButtonColor: '#6777ef',
                    });
                    return; // Hentikan eksekusi lebih lanjut
                }

                // Jika validasi berhasil, kirim form
                var formData = new FormData();
                formData.append('email', email);
                formData.append('name', name);
                formData.append('username', username);
                formData.append('alamat', alamat);
                formData.append('telephone', telephone);
                formData.append('password', password);
                formData.append('confirm_password', confirmPassword);

                $.ajax({
                    url: '/api/admin/manajemen/data-donasi',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    // success: function(data) {
                    //     window.location.href = '/apps/data_donasi/view';
                    // },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan',
                            confirmButtonColor: '#6777ef',
                        }).then(function() {
                            window.location.href = '/apps/data_donasi/view';
                        });
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
