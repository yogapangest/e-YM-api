@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Donasi | e-YM</title>
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
                                <h4>Daftar Donatur</h4>
                                <div class="card-header-form d-flex justify-content-between align-items-center">
                                    <a href="{{ route('index.create.datadonasi') }}" style="float: right;"
                                        class="btn btn-round btn-primary mb-3">Tambah</a>
                                    <form class="mb-3" id="search-form">
                                        <div class="input-group ">
                                            <input id="search" type="text" class="form-control"
                                                placeholder="Cari Nama/Alamat">
                                            <div class="input-group-btn">
                                                <button id="search-btn" type="button" class="btn btn-primary"><i
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
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th>E-mail</th>
                                            <th class="text-center">Rekap</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        <tbody id="table-data-donasi">
                                            {{-- data donasi --}}
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
            function searchUsers(query) {
                $.ajax({
                    url: '/api/admin/manajemen/data-donasi',
                    method: 'GET',
                    data: {
                        search: query
                    },
                    success: function(data) {
                        if (Array.isArray(data.user)) {
                            var tableBody = $('#table-data-donasi');
                            tableBody.empty(); // Bersihkan tabel sebelum menambahkan baris baru

                            var index = 1;
                            // Iterasi setiap pengguna dalam data
                            data.user.forEach(function(user) {
                                // Buat baris tabel baru
                                var row = $('<tr></tr>');

                                // Tambahkan data kolom
                                row.append('<td>' + index + '</td>');
                                row.append('<td>' + user.name + '</td>');
                                row.append('<td>' + user.alamat + '</td>');
                                row.append('<td>' + user.telephone + '</td>');
                                row.append('<td>' + user.email + '</td>');

                                row.append('<td><a href="' + '/apps/donasi/view/' + user.id +
                                    '" class="btn btn-primary"><i class="fas fa-clipboard-list"></i></a></td>'
                                );

                                row.append(
                                    '<td style="display: flex; justify-content: center; align-items: center;"><a href="' +
                                    '/apps/data_donasi/' + user.id + '/edit' +
                                    '" class="mr-1 btn btn-primary"><i class="fas fa-edit"></i></a><button data-id="' +
                                    user.id +
                                    '" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button></td>'
                                );

                                // Tambahkan baris ke dalam tabel
                                tableBody.append(row);

                                index++;
                            });

                            $('.delete-button').on('click', function() {
                                var id_data_donasi = $(this).data('id');
                                deleteDataDonasi(id_data_donasi, $(this).closest('tr'));
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:', error);
                    }
                });
            }

            // Panggil fungsi pencarian saat halaman dimuat
            searchUsers('');

            // Event handler untuk pencarian
            $('#search-btn').on('click', function() {
                var query = $('#search').val();
                searchUsers(query);
            });

            $('#search-form').on('submit', function(event) {
                event.preventDefault(); // Mencegah form dari submit
                var query = $('#search').val();
                searchUsers(query);
            });

            // function deleteDataDonasi(id_data_donasi, row) {
            //     if (confirm('Apa Anda yakin ingin menghapus Data User ini?')) {
            //         $.ajax({
            //             url: '/api/admin/manajemen/data-donasi/delete/' + id_data_donasi,
            //             method: 'DELETE',
            //             headers: {
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             success: function(response) {
            //                 if (response.status === 'success') {
            //                     alert('Data Donasi deleted successfully');
            //                     // Remove the data row from the table
            //                     row.remove();
            //                 } else {
            //                     alert('Failed to delete Data Donasi');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error('There has been a problem with your AJAX operation:', error);
            //             }
            //         });
            //     }
            // }

            function deleteDataDonasi(id_data_donasi, row) {
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
                            url: '/api/admin/manajemen/data-donasi/delete/' + id_data_donasi,
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
                                        window.location.href = '/apps/data_donasi/view';
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
