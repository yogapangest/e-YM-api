@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Program</h4>
                        </div>
                        <div class="card-body">
                            <form id="ProgramForm" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="nama_program">Nama</label>
                                    <input id="nama_program" type="text"
                                        class="form-control @error('nama_program') is-invalid @enderror" name="nama_program"
                                        value="{{ old('nama_program') }}" placeholder="nama program">
                                    @error('nama_program')
                                        <div id="nama_program" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <input id="deskripsi" type="text"
                                        class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
                                        value="{{ old('deskripsi') }}" placeholder="Deskripsi">
                                    @error('deskripsi')
                                        <div id="deskripsi" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="file" class="form-label">file</label>
                                    <input type="file" class="form-control" id="file" name="file">
                                    @error('file')
                                        <div id="file" class="form-file">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        Tambah Program
                                    </button>
                                </div>

                                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                <script src="{{ asset('js/program.js') }}"></script>


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

            $('#ProgramForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('nama_program', $('#nama_program').val());
                formData.append('deskripsi', $('#deskripsi').val());

                if ($('#file')[0].files[0]) {
                    formData.append('file', $('#file')[0].files[0]);
                }

                $.ajax({
                    url: '/api/admin/manajemen/program',
                    method: 'POST',
                    contentType: 'application/json',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.href = '/apps/program/view';
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
