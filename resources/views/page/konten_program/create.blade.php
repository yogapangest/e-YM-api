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
    <script>
        $(document).ready(function() {

            $('#KontenProgramForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData();
                formData.append('nama_kontenprogram', $('#nama_kontenprogram').val());
                if ($('#foto')[0].files[0]) {
                    formData.append('foto', $('#foto')[0].files[0]);
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
                        window.location.href = '/apps/konten_program/view';
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
