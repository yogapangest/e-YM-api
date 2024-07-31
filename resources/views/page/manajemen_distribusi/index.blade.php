@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Distribusi | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }} ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
@endsection

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row pt-2">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Daftar Distribusi</h4>

                                <div class="card-header-form d-flex justify-content-between align-items-center">
                                    <a href="{{ route('index.create.distribusi') }}"
                                        class="btn btn-round btn-primary mb-3">Tambah</a>
                                    <form id="search-form" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" id="search-query" class="form-control" name="q"
                                                placeholder="Search" value="{{ isset($query) ? $query : '' }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No</th>
                                            <th>Program</th>
                                            <th>Tanggal</th>
                                            <th>Tempat</th>
                                            <th>Penerima Manfaat</th>
                                            <th>Anggaran</th>
                                            <th>Pengeluaran</th>
                                            <th>Sisa</th>
                                            <th>File</th>
                                            <th class="text-center">Data Barang</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>

                                        <tbody id="table-distribusi">
                                            {{-- data distribusi --}}
                                        </tbody>

                                    </table>
                                </div>
                            </div>
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
            function loadDistribusi(query = '') {
                $.ajax({
                    url: '/api/admin/manajemen/distribusi',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    success: function(data) {
                        if (Array.isArray(data.distribusi)) {
                            var tableBody = $('#table-distribusi');
                            tableBody.empty(); // Kosongkan tabel sebelum memuat data baru

                            var index = 1;
                            data.distribusi.forEach(function(distribusi) {
                                var date = new Date(distribusi.tanggal);
                                var formattedDate = formatTanggal(date);

                                var row = $('<tr></tr>');

                                row.append('<td style="padding: 10px 45;">' + index + '</td>');
                                row.append('<td style="padding: 10px 45;">' + distribusi.program
                                    .nama_program + '</td>');
                                row.append('<td style="padding: 13px 38px;">' + formattedDate +
                                    '</td>');
                                row.append('<td style="padding: 10px 45;">' + distribusi
                                    .tempat + '</td>');
                                row.append('<td style="padding: 10px 45;">' + distribusi
                                    .penerima_manfaat + '</td>');
                                row.append('<td style="padding: 10px 45;">' + formatRupiah(
                                    distribusi.anggaran) + '</td>');
                                row.append('<td style="padding: 10px 45;">' + formatRupiah(
                                    distribusi.pengeluaran) + '</td>');
                                row.append('<td style="padding: 10px 45;">' + formatRupiah(
                                    distribusi.sisa) + '</td>');

                                var fileUrl = distribusi.file;

                                if (!fileUrl) {
                                    row.append(
                                        '<td style="padding: 10px 45;">Tidak ada file</td>');
                                } else {
                                    var fileExtension = fileUrl.split('.').pop().toLowerCase();

                                    if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                        row.append(
                                            '<td style="padding: 10px 45;"><img src="/file/distribusi/' +
                                            fileUrl + '" alt="' + distribusi.file +
                                            '" style="width: 70px; height: auto; border-radius: 0;"></td>'
                                        );
                                    } else if (fileExtension === 'pdf') {
                                        row.append(
                                            '<td style="padding: 10px 45;"><a href="/file/distribusi/' +
                                            fileUrl +
                                            '" class="btn btn-primary"><i class="fas fa-file"></i></a></td>'
                                        );
                                    }
                                }

                                row.append(
                                    '<td style="padding: 10px 45;"><a href="/apps/distribusi_barang/view/' +
                                    distribusi.id +
                                    '" class="btn btn-primary"><i class="fas fa-shopping-cart"></i></a></td>'
                                );
                                row.append(
                                    '<td style="padding: 10px 45;" class="d-flex align-items-center"><a href="/apps/distribusi/' +
                                    distribusi.id +
                                    '/edit" class="mr-1 btn btn-primary"><i class="fas fa-edit"></i></a><button data-id="' +
                                    distribusi.id +
                                    '" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button></td>'
                                );

                                tableBody.append(row);
                                index++;
                            });

                            $('.delete-button').on('click', function() {
                                var distribusi = $(this).data('id');
                                deleteDistribusi(distribusi, $(this).closest('tr'));
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:', error);
                    }
                });
            }

            function formatTanggal(date) {
                var bulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September",
                    "Oktober", "November", "Desember"
                ];
                var tanggal = date.getDate();
                var bulanNama = bulan[date.getMonth()];
                var tahun = date.getFullYear();
                return tanggal + ' ' + bulanNama + ' ' + tahun;
            }

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }



            function deleteDistribusi(distribusi, row) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda tidak dapat mengembalikan data yang telah dihapus!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6777ef',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/api/admin/manajemen/distribusi/delete/' + distribusi,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                console.log(response); // Log respons untuk debugging
                                if (response.status === 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses',
                                        text: response.message,
                                        confirmButtonColor: '#6777ef',
                                    }).then(function() {
                                        window.location.href = '/apps/distribusi/view';
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message ||
                                            'Data tidak dapat dihapus',
                                        confirmButtonColor: '#6777ef',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Terjadi masalah dengan operasi AJAX Anda:',
                                    error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat menghapus data',
                                    confirmButtonColor: '#6777ef',
                                });
                            }
                        });
                    }
                });
            }

            // Load data awal
            loadDistribusi();

            // Event listener untuk form pencarian
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                var query = $('#search-query').val();
                loadDistribusi(query);
            });
        });
    </script>
@endsection

@section('script')
    {{-- Datatable JS --}}
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

    {{-- Modal JS --}}
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
@endsection
