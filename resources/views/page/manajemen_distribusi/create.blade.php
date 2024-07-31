@extends('administrator.layouts.app')


@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">



            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Distribusi</h4>
                        </div>
                        <div class="card-body">
                            <form id="DistribusiForm" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label for="programs_id">Program</label>
                                    <select id="programs_id" class="form-control @error('programs_id') is-invalid @enderror"
                                        name="programs_id">
                                        <option value="" selected disabled>Pilih Program</option>
                                    </select>
                                    @error('programs_id')
                                        <div id="programs_id" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input id="tanggal" type="date"
                                        class="form-control @error('tanggal') is-invalid @enderror" name="tanggal"
                                        value="{{ old('tanggal') }}">
                                    @error('tanggal')
                                        <div id="tanggal" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input id="tempat" type="text"
                                        class="form-control @error('tempat') is-invalid @enderror" name="tempat"
                                        value="{{ old('tempat') }}" placeholder="Tempat">
                                    @error('tempat')
                                        <div id="tempat" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="penerima_manfaat">Penerima Manfaat</label>
                                    <input id="penerima_manfaat" type="text"
                                        class="form-control @error('penerima_manfaat') is-invalid @enderror"
                                        name="penerima_manfaat" value="{{ old('penerima_manfaat') }}"
                                        placeholder="Penerima Manfaat">
                                    @error('penerima_manfaat')
                                        <div id="penerima_manfaat" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="anggaran">Anggaran</label>
                                    <input id="anggaran_display" type="text"
                                        class="form-control @error('anggaran') is-invalid @enderror" name="anggaran_display"
                                        value="{{ old('anggaran_display') }}" placeholder="Anggaran">
                                    <input id="anggaran" type="hidden" name="anggaran" value="{{ old('anggaran') }}">
                                    @error('anggaran')
                                        <div id="anggaran_error" class="form-text">{{ $message }}</div>
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
                                        Tambah Distribusi
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('js/distribusi.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <!-- Sertakan SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Sertakan file JavaScript eksternal -->
    <script src="{{ asset('js/distribusi.js') }}"></script>

    <!-- Sertakan jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {

            // Load Program Data
            $.ajax({
                url: '/api/admin/manajemen/program',
                method: 'GET',
                success: function(data) {
                    if (Array.isArray(data.program)) {
                        var programDropdown = $('#programs_id');
                        programDropdown.empty();
                        programDropdown.append(
                            '<option value="" selected disabled>Pilih Program</option>');
                        data.program.forEach(function(program) {
                            programDropdown.append(new Option(program.nama_program, program
                                .id));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            $('#DistribusiForm').submit(function(event) {
                event.preventDefault();

                let isValid = true;
                let fields = [{
                        id: "programs_id",
                        message: "Program harus diisi"
                    },
                    {
                        id: "tanggal",
                        message: "Tanggal harus diisi"
                    },
                    {
                        id: "tempat",
                        message: "Tempat harus diisi"
                    },
                    {
                        id: "penerima_manfaat",
                        message: "Penerima Manfaat harus diisi"
                    },
                    {
                        id: "anggaran_display",
                        message: "Anggaran harus diisi"
                    },
                    {
                        id: "file",
                        message: "File harus diisi"
                    },
                ];

                for (let field of fields) {
                    let element = document.getElementById(field.id);
                    if (!element.value) {
                        isValid = false;
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: field.message,
                            confirmButtonColor: "#6777ef",
                        });
                        element.focus();
                        break; // Stop checking further fields after the first empty field is found
                    }
                }

                if (isValid) {
                    var formData = new FormData($('#DistribusiForm')[0]);

                    $.ajax({
                        url: '/api/admin/manajemen/distribusi',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil disimpan',
                                confirmButtonColor: '#6777ef',
                            }).then(function() {
                                window.location.href = '/apps/distribusi/view';
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error('There has been a problem with your AJAX operation:',
                                error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
