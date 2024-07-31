@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Konten Program</h4>
                        </div>
                        <div class="card-body">
                            <form id="KontenProgramForm" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_kontenprogram">Nama</label>
                                    <input id="nama_kontenprogram" type="text"
                                        class="form-control @error('nama_kontenprogram') is-invalid @enderror"
                                        name="nama_kontenprogram" value="{{ old('nama_kontenprogram') }}"
                                        placeholder="Nama ">
                                    @error('nama_kontenprogram')
                                        <div id="nama_kontenprogram" class="form-text"></div>
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

            $('#KontenProgramForm').submit(function(event) {
                event.preventDefault();

                // Ambil nilai dari setiap input
                var namaKontenProgram = $('#nama_kontenprogram').val();
                var foto = $('#foto')[0].files[0];

                // Validasi form
                let isValid = true;
                let errorMessage = '';

                if (!namaKontenProgram) {
                    isValid = false;
                    errorMessage = 'Nama konten program harus diisi';
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
                formData.append('nama_kontenprogram', namaKontenProgram);
                if (foto) {
                    formData.append('foto', foto);
                }

                $.ajax({
                    url: '/api/admin/manajemen/kontenprogram',
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
                            window.location.href = '/apps/konten_program/view';
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
