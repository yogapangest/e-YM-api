@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">

            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Jenis Arsip</h4>
                        </div>
                        <div class="card-body">
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

                                <div class="form-group">
                                    <label for="nama_arsip">Nama Jenis Arsip</label>
                                    <input id="nama_arsip" type="text"
                                        class="form-control @error('nama_arsip') is-invalid @enderror" name="nama_arsip">
                                    @error('nama_arsip')
                                        <div id="nama_arsip" class="form-text">{{ $message }}</div>
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
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Simpan Jenis Arsip
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
            var id_jenis_arsip = segments[segments.length - 2];
            console.log(id_jenis_arsip)
            // Mendapatkan data program untuk edit
            $.ajax({
                url: '/api/admin/manajemen/jenis-arsip/edit/' + id_jenis_arsip,
                // Sesuaikan URL API Anda untuk mendapatkan data program
                method: 'GET',
                success: function(data) {
                    if (data.status === "success") {
                        var jenis_arsip = data.jenisarsip;
                        console.log(data)

                        $('#nama_arsip').val(jenis_arsip.nama_arsip);
                        $('#deskripsi').val(jenis_arsip.deskripsi);
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
                formData.append('nama_arsip', $('#nama_arsip').val());
                formData.append('deskripsi', $('#deskripsi').val());


                $.ajax({
                    url: '/api/admin/manajemen/jenis-arsip/update/' +
                        id_jenis_arsip, // Sesuaikan URL API Anda untuk update program
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
