@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Program</h4>
                        </div>
                        <div class="card-body">
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group">
                                    <label for="nama_program">Nama</label>
                                    <input id="nama_program" type="text"
                                        class="form-control @error('nama') is-invalid @enderror" name="nama_program">
                                    @error('nama_program')
                                        <div id="nama_program" class="form-text">{{ $message }}</div>
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
                                    <label for="file" class="form-label">File</label>
                                    <input type="file" class="form-control @error('file') is-invalid @enderror"
                                        id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div id="preview-container" class="border p-2 d-none">
                                        <h6>Preview File:</h6>
                                        <div id="file-preview"></div>
                                    </div>
                                </div>



                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Program
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
            var id_program = segments[segments.length - 2];
            console.log(id_program)
            // Mendapatkan data program untuk edit
            $.ajax({
                url: '/api/admin/manajemen/program/edit/' + id_program,
                // Sesuaikan URL API Anda untuk mendapatkan data program
                method: 'GET',
                success: function(data) {
                    if (data.status === "success") {
                        console.log(data)
                        var program = data.program;

                        $('#nama_program').val(program.nama_program);
                        $('#deskripsi').val(program.deskripsi);
                        $('#file').val(program.file);


                        var fileUrl = program.file; // URL file
                        var filePreview = $('#file-preview');

                        // Tentukan tipe file berdasarkan ekstensi
                        var fileExtension = fileUrl.split('.').pop().toLowerCase();
                        var previewContent = '';

                        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                            // Jika file gambar, buat elemen img
                            previewContent = '<img src="' + '/file/program/' + fileUrl +
                                '" alt="Preview" class="img-fluid">';
                        } else if (fileExtension === 'pdf') {
                            // Jika file PDF, buat elemen embed
                            previewContent = '<embed src="' + '/file/program/' + fileUrl +
                                '" type="application/pdf" width="100%" height="400px">';
                        } else {
                            // Jika file tipe lain, buat link untuk mengunduh
                            previewContent = '<a href="' + '/file/program/' + fileUrl +
                                '" target="_blank">Lihat File</a>';
                        }
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
                formData.append('nama_program', $('#nama_program').val());
                formData.append('deskripsi', $('#deskripsi').val());

                if ($('#file')[0].files.length > 0) {
                    formData.append('file', $('#file')[0].files[0]);
                }

                $.ajax({
                    url: '/api/admin/manajemen/program/update/' +
                        id_program, // Sesuaikan URL API Anda untuk update program
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT' // Method Override untuk menggunakan PUT
                    },
                    // success: function(data) {
                    //     console.log(data);
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
