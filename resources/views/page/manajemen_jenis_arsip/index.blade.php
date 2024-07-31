@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Jenis Arsip | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }} ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-rHy3mowRf3m1OPbK6UVDu+OIaNRszJ8z7XeR+AhB0mEgwZOVtBijqUMs7Wjg87YQzPKdJU+zjlz4hJOuxYYplg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                                <h4>Daftar Jenis Arsip</h4>

                                <div class="card-header-form d-flex justify-content-between align-items-center">

                                    <a href="{{ route('index.create') }}" style="float: right;"
                                        class="btn btn-round btn-primary mb-3">Tambah</a>

                                    {{-- <form class="mb-3">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form> --}}
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Keterangan</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>

                                        <tbody id='table-jenis-arsip'>
                                            {{-- data jenis arsip --}}
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
            $.ajax({
                url: '/api/admin/manajemen/jenis-arsip',
                method: 'GET',
                success: function(data) {
                    if (Array.isArray(data.jenisarsip)) {
                        var tableBody = $('#table-jenis-arsip');

                        var index = 1;
                        // Iterasi setiap kegiatan dalam data
                        data.jenisarsip.forEach(function(jenisarsips) {
                            // Buat baris tabel baru
                            var row = $('<tr></tr>');

                            // Tambahkan data kolom
                            row.append('<td>' + index + '</td>');
                            row.append('<td>' + jenisarsips.nama_arsip + '</td>');
                            row.append('<td>' + jenisarsips.deskripsi + '</td>');


                            row.append(
                                '<td style="display: flex; justify-content: center; align-items: center;"><a href="' +
                                '/apps/jenis-arsip/' + jenisarsips
                                .id +
                                '/edit' +
                                '" class="mr-1 btn btn-primary"><i class="fas fa-edit"></i></a><button data-id="' +
                                jenisarsips.id +
                                '" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button></td>'
                            );


                            // Tambahkan baris ke dalam tabel
                            tableBody.append(row);

                            index++;

                        });

                        $('.delete-button').on('click', function() {
                            var id_jenis_arsip = $(this).data('id');
                            // console.log(id_jenis_arsip);
                            deleteJenisArsip(id_jenis_arsip, $(this).closest('tr'));

                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            // function deleteProgram(id_jenis_arsip, row) {
            //     if (confirm('Apa Anda yakin ingin menghapus Jenis Arsip ini?')) {
            //         $.ajax({
            //             url: '/api/admin/manajemen/jenis-arsip/delete/' + id_jenis_arsip,
            //             method: 'DELETE',
            //             headers: {
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             success: function(response) {
            //                 if (response.status === 'success') {
            //                     alert('Jenis Arsip deleted successfully');
            //                     // Remove the kegiatan row from the table
            //                     row.remove();

            //                 } else {
            //                     alert('Failed to delete Jenis Arsip');
            //                 }
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error('There has been a problem with your AJAX operation:', error);
            //             }
            //         });
            //     }
            // }

            function deleteJenisArsip(id_jenis_arsip, row) {
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
                            url: '/api/admin/manajemen/jenis-arsip/delete/' + id_jenis_arsip,
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
                                        window.location.href = '/apps/jenis-arsip/view';
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
