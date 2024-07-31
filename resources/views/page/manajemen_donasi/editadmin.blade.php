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
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                        value="{{ old('deskripsi') }}">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nominal_display">Nominal</label>
                                    <input id="nominal_display" type="text"
                                        class="form-control @error('nominal_display') is-invalid @enderror"
                                        name="nominal_display" value="{{ old('nominal_display') }}">
                                    <input id="nominal" type="hidden" name="nominal" value="{{ old('nominal') }}">
                                    @error('nominal')
                                        <div id="nominal_display" class="form-text">{{ $message }}</div>
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
            var rekapDonasiId = window.location.pathname.split('/')[4];

            // Mendapatkan data yang ada dan mengisi form
            $.ajax({
                url: '/api/admin/manajemen/rekap-donasi/edit/' + rekapDonasiId,
                method: 'GET',
                success: function(data) {
                    if (data.donasi) {
                        $('#deskripsi').val(data.donasi.deskripsi);
                        $('#nominal_display').val(formatRupiah(data.donasi.nominal));
                    } else {
                        console.error('Unexpected data format:', data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            function parseRupiah(rupiah) {
                return rupiah.replace(/[^0-9]/g, '');
            }

            $('#nominal_display').on('input', function() {
                var rawValue = parseRupiah($(this).val());
                $('#nominal').val(rawValue);
                $(this).val(formatRupiah(rawValue));
            });

            // Mengirim data yang diperbarui saat form disubmit
            $('#UpdateForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                formData.set('nominal', $('#nominal').val());

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
