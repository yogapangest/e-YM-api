@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Jenis Arsip</h4>
                        </div>
                        <div class="card-body">
                            <form id="JenisArsipForm" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_arsip">Nama Arsip</label>
                                    <input id="nama_arsip" type="text"
                                        class="form-control @error('nama_arsip') is-invalid @enderror" name="nama_arsip"
                                        value="{{ old('nama_arsip') }}" placeholder="Nama Jenis Arsip">
                                    @error('nama_arsip')
                                        <div id="nama_arsip" class="form-text"></div>
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
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Jenis Arsip
                                    </button>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                <script src="{{ asset('js/jenis_arsip.js') }}"></script>
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

            $('#JenisArsipForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('nama_arsip', $('#nama_arsip').val());
                formData.append('deskripsi', $('#deskripsi').val());

                $.ajax({
                    url: '/api/admin/manajemen/jenis-arsip',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.href = '/apps/jenis-arsip/view';
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
