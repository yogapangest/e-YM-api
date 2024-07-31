@extends('administrator.layouts.app')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row pt-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Program</h4>
                        </div>
                        <div class="card-body">
                            <form id="UpdateForm" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">

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
                                        class="form-control @error('tanggal') is-invalid @enderror" name="tanggal">
                                    @error('tanggal')
                                        <div id="tanggal" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input id="tempat" type="text"
                                        class="form-control @error('tempat') is-invalid @enderror" name="tempat">
                                    @error('tempat')
                                        <div id="tempat" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="penerima_manfaat">Penerima Manfaat</label>
                                    <input id="penerima_manfaat" type="text"
                                        class="form-control @error('penerima_manfaat') is-invalid @enderror"
                                        name="penerima_manfaat">
                                    @error('penerima_manfaat')
                                        <div id="penerima_manfaat" class="form-text">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="anggaran_display">Anggaran</label>
                                    <input type="text" id="anggaran_display" class="form-control">
                                    <input type="hidden" id="anggaran" name="anggaran">
                                </div>

                                {{-- <div class="form-group">
                                    <label for="pengeluaran_display">Pengeluaran</label>
                                    <input type="text" id="pengeluaran_display" class="form-control">
                                    <input type="hidden" id="pengeluaran" name="pengeluaran">
                                </div> --}}
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
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {

            var distribsuiId = window.location.pathname.split('/')[3];
            var data_program = '';
            $.ajax({
                url: '/api/admin/manajemen/distribusi/edit/' + distribsuiId,
                method: 'GET',
                success: function(data) {
                    if (data && data.distribusi) {
                        data_program = data.distribusi.program.nama_program;
                        $('#tanggal').val(data.distribusi.tanggal);
                        $('#tempat').val(data.distribusi.tempat);
                        $('#penerima_manfaat').val(data.distribusi.penerima_manfaat);
                        // Format anggaran and pengeluaran to Rupiah and set raw values
                        $('#anggaran_display').val(formatRupiah(data.distribusi.anggaran));
                        $('#anggaran').val(data.distribusi.anggaran);

                        // $('#pengeluaran_display').val(formatRupiah(data.distribusi.pengeluaran));
                        $('#pengeluaran').val(data.distribusi.pengeluaran);
                        $('#file').val(data.distribusi.file);

                    } else {
                        console.error('Unexpected data format:', data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }

            });
            // Function to format number to Rupiah
            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            function parseRupiah(rupiah) {
                return rupiah.replace(/[^0-9]/g, '');
            }

            $('#anggaran_display').on('input', function() {
                var rawValue = parseRupiah($(this).val());
                $('#anggaran').val(rawValue);
                $(this).val(formatRupiah(rawValue));
            });

            // $('#pengeluaran_display').on('input', function() {
            //     var rawValue = parseRupiah($(this).val());
            //     $('#pengeluaran').val(rawValue);
            //     $(this).val(formatRupiah(rawValue));
            // });

            // Load Program Data
            $.ajax({
                url: '/api/admin/manajemen/program',
                method: 'GET',
                success: function(data) {
                    if (Array.isArray(data.program)) {
                        var programDropdown = $('#programs_id');
                        data.program.forEach(function(program) {
                            var option;
                            if (data_program == program.nama_program) {
                                option = new Option(program.nama_program, program.id, true,
                                    true);
                            } else {
                                option = new Option(program.nama_program, program.id);
                            }
                            programDropdown.append(option);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            $('#UpdateForm').submit(function(event) {
                event.preventDefault();

                var formData = new FormData(this);
                // formData.append('anggaran', $('#anggaran_display').val());
                // formData.append('pengeluaran', $('#pengeluaran_display').val());


                $.ajax({
                    url: '/api/admin/manajemen/distribusi/update/' + distribsuiId,
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
                            window.location.href = '/apps/distribusi/view';
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
