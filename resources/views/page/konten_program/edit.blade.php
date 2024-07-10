@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Konten Program</h4>
                        </div>
                        <div class="card-body">
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group">
                                    <label for="nama_kontenprogram">Nama</label>
                                    <input id="nama_kontenprogram" type="text"
                                        class="form-control @error('nama_kontenprogram') is-invalid @enderror"
                                        name="nama_kontenprogram">
                                    @error('nama_kontenprogram')
                                        <div id="nama_kontenprogram" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    @error('foto')
                                        <div id="foro" class="text-danger"> {{ $message }}</div>
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
    <script>
        $(document).ready(function() {
            var url = window.location.href; // Ambil URL lengkap dari browser
            var segments = url.split('/'); // Pisahkan URL berdasarkan "/"
            var id_konten_program = segments[segments.length - 2];
            console.log(id_konten_program)
            // Mendapatkan data program untuk edit
            $.ajax({
                url: '/api/admin/manajemen/kontenprogram/edit/' + id_konten_program,
                // Sesuaikan URL API Anda untuk mendapatkan data program
                method: 'GET',
                success: function(data) {
                    if (data.status === "success") {
                        console.log(data)
                        var konten_program = data.kontenprogram;

                        $('#nama_kontenprogram').val(konten_program.nama_kontenprogram);
                        $('#foto').val(konten_program.foto);
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
                formData.append('nama_kontenprogram', $('#nama_kontenprogram').val());

                if ($('#foto')[0].files.length > 0) {
                    formData.append('foto', $('#foto')[0].files[0]);
                }

                $.ajax({
                    url: '/api/admin/manajemen/kontenprogram/update/' +
                        id_konten_program, // Sesuaikan URL API Anda untuk update program
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT' // Method Override untuk menggunakan PUT
                    },
                    success: function(data) {
                        console.log(data);
                        window.location.href = data
                            .url; // Redirect ke halaman setelah berhasil disimpan
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
