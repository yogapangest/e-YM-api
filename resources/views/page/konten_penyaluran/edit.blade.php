@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Konten Penyaluran</h4>
                        </div>
                        <div class="card-body">
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group">
                                    <label for="nama_penyaluran">Nama</label>
                                    <input id="nama_penyaluran" type="text"
                                        class="form-control @error('nama_penyaluran') is-invalid @enderror"
                                        name="nama_penyaluran">
                                    @error('nama_penyaluran')
                                        <div id="nama_penyaluran" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input id="deskripsi" type="text"
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    @error('foto')
                                        <div id="foto" class="text-danger">{{ $message }}</div>
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
            var url = window.location.href; // Ambil URL lengkap dari browser
            var segments = url.split('/'); // Pisahkan URL berdasarkan "/"
            var id_konten_penyaluran = segments[segments.length - 2];
            // console.log(id_konten_penyaluran)
            // Mendapatkan data program untuk edit
            $.ajax({
                url: '/api/admin/manajemen/kontenpenyaluran/edit/' + id_konten_penyaluran,
                // Sesuaikan URL API Anda untuk mendapatkan data program
                method: 'GET',
                success: function(data) {
                    if (data.status === "success") {
                        console.log(data)
                        var konten_penyaluran = data.kontenpenyaluran;

                        $('#nama_penyaluran').val(konten_penyaluran.nama_penyaluran);
                        $('#deskripsi').val(konten_penyaluran.deskripsi);
                        $('#foto').val(konten_penyaluran.foto);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });


            // Menangani form submission untuk update
            $('#UpdateForm').on('submit', function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('nama_penyaluran', $('#nama_penyaluran').val());
                formData.append('deskripsi', $('#deskripsi').val());

                if ($('#foto')[0].files.length > 0) {
                    formData.append('foto', $('#foto')[0].files[0]);
                }

                $.ajax({
                    url: '/api/admin/manajemen/kontenpenyaluran/update/' +
                        id_konten_penyaluran, // Sesuaikan URL API Anda untuk update program
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT' // Method Override untuk menggunakan PUT
                    },
                    // success: function(data) {
                    //     // console.log(data);
                    //     window.location.href = data
                    //         .url; // Redirect ke halaman setelah berhasil disimpan
                    // },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses',
                            text: 'Data berhasil disimpan',
                            confirmButtonColor: '#6777ef',
                        }).then(function() {
                            window.location.href = data.url;
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
