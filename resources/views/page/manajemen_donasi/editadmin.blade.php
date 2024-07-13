@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Donasi</h4>
                        </div>
                        <div class="card-body">
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input id="deskripsi" type="text"
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input id="nominal" type="text"
                                        class="form-control @error('nominal') is-invalid @enderror" name="nominal">
                                    @error('nominal')
                                        <div id="nominal" class="form-text">{{ $message }}</div>
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
                                    <button type="submit" class="btn btn-primary">
                                        Update Donasi
                                    </button>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var nominalInput = document.getElementById('nominal');

                                        nominalInput.addEventListener('input', function(e) {
                                            // Menghilangkan karakter non-digit
                                            var value = e.target.value.replace(/[^,\d]/g, '');

                                            // Mengubah menjadi format angka dengan titik
                                            e.target.value = new Intl.NumberFormat('id-ID').format(value);
                                        });

                                        // Fungsi untuk menghilangkan format saat mengirim data
                                        nominalInput.closest('form').addEventListener('submit', function() {
                                            nominalInput.value = nominalInput.value.replace(/\./g, '');
                                        });
                                    });
                                </script>

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
            var rekapDonasiId = window.location.pathname.split('/')[4];

            // Mendapatkan data yang ada dan mengisi form
            $.ajax({
                url: '/api/admin/manajemen/rekap-donasi/edit/' + rekapDonasiId,
                method: 'GET',
                success: function(data) {
                    if (data.donasi) {
                        console.log(data.donasi)
                        $('#users_id').val(data.donasi.users_id);
                        $('#deskripsi').val(data.donasi.deskripsi);
                        $('#nominal').val(data.donasi.nominal);
                        $('#file').val(data.donasi.file);


                    } else {
                        console.error('Unexpected data format:', data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            // Mengirim data yang diperbarui saat form disubmit
            $('#UpdateForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                // formData.append('distribusis_id', $('#distribusis_id').val());
                // formData.append('nama_barang', $('#nama_barang').val());
                // formData.append('volume', $('#volume').val());
                // formData.append('satuan', $('#satuan').val());
                // formData.append('harga_satuan', $('#harga_satuan').val());

                $.ajax({
                    url: '/api/admin/manajemen/rekap-donasi/update/' + rekapDonasiId,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-HTTP-Method-Override': 'PUT' // Method Override untuk menggunakan PUT
                    },
                    success: function(data) {
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
