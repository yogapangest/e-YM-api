@extends('administrator.layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Tambah Arsip</h4>
                        </div>
                        <div class="card-body">
                            <form id="arsipForm" method="POST" enctype="multipart/form-data">
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
                                    <label for="jenisarsips_id">Jenis Arsip</label>
                                    <select id="jenisarsips_id"
                                        class="form-control @error('jenisarsips_id') is-invalid @enderror"
                                        name="jenisarsips_id">
                                        <option value="" selected disabled>Pilih Jenis Arsip</option>
                                    </select>
                                    @error('jenisarsips_id')
                                        <div id="jenisarsips_id" class="form-text">{{ $message }}</div>
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
                                        Tambah Arsip
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

            // Load Jenis Arsip Data
            $.ajax({
                url: '/api/admin/manajemen/jenis-arsip',
                method: 'GET',
                success: function(data) {
                    console.log(data); // Tambahkan ini untuk debugging

                    if (Array.isArray(data
                            .jenisarsip)) { // Pastikan nama field sesuai dengan respons API
                        var jenisArsipDropdown = $('#jenisarsips_id');
                        jenisArsipDropdown.empty();
                        jenisArsipDropdown.append(
                            '<option value="" selected disabled>Pilih Jenis Arsip</option>');
                        data.jenisarsip.forEach(function(jenisarsip) {
                            jenisArsipDropdown.append(new Option(jenisarsip.nama_arsip,
                                jenisarsip.id));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });


            // Handle Form Submission
            $('#arsipForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                formData.append('programs_id', $('#programs_id').val());
                formData.append('jenisarsips_id', $('#jenisarsips_id').val());
                if ($('#file')[0].files[0]) {
                    formData.append('file', $('#file')[0].files[0]);
                }

                $.ajax({
                    url: '/api/admin/manajemen/arsip',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        window.location.href = '/apps/arsip/view';
                        loadArsipData(); // Memuat ulang data di halaman index
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
