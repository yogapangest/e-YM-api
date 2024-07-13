@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Donasi</h4>
                        </div>
                        <div class="card-body">
                            <form id="donasiForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input id="deskripsi" type="text"
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                        placeholder="Titipan Do'a">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text"></div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nominal_display">Nominal</label>
                                    <input id="nominal_display" type="text"
                                        class="form-control @error('nominal_display') is-invalid @enderror"
                                        name="nominal_display" placeholder="Nominal" value="{{ old('nominal_display') }}">
                                    <input id="nominal" type="hidden" name="nominal">
                                    @error('nominal')
                                        <div id="nominal-error" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file" class="form-label">file</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file"></div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Donasi
                                    </button>
                                </div>
                                <script>
                                    document.getElementById('nominal_display').addEventListener('input', function(e) {
                                        let displayValue = e.target.value.replace(/\D/g, ''); // Hapus semua karakter non-digit
                                        let formattedValue = displayValue.replace(/\B(?=(\d{3})+(?!\d))/g,
                                            '.'); // Tambahkan titik setiap 3 angka
                                        e.target.value = formattedValue;

                                        // Set nilai asli tanpa format ke hidden input
                                        document.getElementById('nominal').value = displayValue;
                                    });

                                    document.querySelector('form').addEventListener('submit', function(e) {
                                        let displayValue = document.getElementById('nominal_display').value;
                                        let actualValue = displayValue.replace(/\./g, ''); // Hapus titik sebelum submit
                                        document.getElementById('nominal').value = actualValue;
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
    </script>
    <script>
        $(document).ready(function() {

            $('#donasiForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('deskripsi', $('#deskripsi').val());
                formData.append('nominal', $('#nominal').val());

                if ($('#file')[0].files[0]) {
                    formData.append('file', $('#file')[0].files[0]);
                }

                $.ajax({
                    url: '/api/user/manajemen/formdonasi',
                    method: 'POST',
                    contentType: 'application/json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.href = '/apps/donasi/user/view';
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
