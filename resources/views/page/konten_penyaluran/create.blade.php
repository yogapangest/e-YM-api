@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Konten Penyaluran</h4>
                        </div>
                        <div class="card-body">
                            <form id="KontenPenyaluranForm" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_penyaluran">Nama</label>
                                    <input id="nama_penyaluran" type="text"
                                        class="form-control @error('nama_penyaluran') is-invalid @enderror"
                                        name="nama_penyaluran" value="{{ old('nama_penyaluran') }}" placeholder="Nama ">
                                    @error('nama_penyaluran')
                                        <div id="nama_penyaluran" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input id="deskripsi" type="text"
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                        value="{{ old('deskripsi') }}" placeholder="Deskripsi">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    @error('foto')
                                        <div class="text-danger"></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah
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

            $('#KontenPenyaluranForm').submit(function(event) {
                event.preventDefault();

                // Ambil nilai dari setiap input
                var namaPenyaluran = $('#nama_penyaluran').val();
                var deskripsi = $('#deskripsi').val();
                var foto = $('#foto')[0].files[0];

                // Validasi form
                let isValid = true;
                let errorMessage = '';

                if (!namaPenyaluran) {
                    isValid = false;
                    errorMessage = 'Nama penyaluran harus diisi';
                } else if (!deskripsi) {
                    isValid = false;
                    errorMessage = 'Deskripsi harus diisi';
                } else if (!foto) {
                    isValid = false;
                    errorMessage = 'Foto harus diunggah';
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
                formData.append('nama_penyaluran', namaPenyaluran);
                formData.append('deskripsi', deskripsi);
                if (foto) {
                    formData.append('foto', foto);
                }

                $.ajax({
                    url: '/api/admin/manajemen/kontenpenyaluran',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan',
                            confirmButtonColor: '#6777ef',
                        }).then(function() {
                            window.location.href = '/apps/konten_penyaluran/view';
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:',
                            error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat menyimpan data',
                            confirmButtonColor: '#6777ef',
                        });
                    }
                });
            });
        });
    </script>
@endsection
