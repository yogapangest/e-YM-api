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
                                <h4>Daftar Donasi</h4>
                                <div class="card-header-form">
                                    <div class="ml-auto mb-2">
                                        <a href="{{ route('index.create.datadonasi') }}" style="float: right;"
                                            class="btn btn-round btn-primary mb-3">Tambah</a>
                                    </div>
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/admin/manajemen/data-donasi',
                method: 'GET',
                success: function(data) {
                    if (Array.isArray(data.user)) {
                        var tableBody = $('#table-data-donasi');

                        var index = 1;
                        // Iterasi setiap kegiatan dalam data
                        data.user.forEach(function(user) {
                            // Buat baris tabel baru
                            var row = $('<tr></tr>');

                            // Tambahkan data kolom
                            row.append('<td>' + index + '</td>');
                            row.append('<td>' + user.name + '</td>');
                            row.append('<td>' + user.alamat + '</td>');
                            row.append('<td>' + user.telephone + '</td>');
                            row.append('<td>' + user.email + '</td>');

                            row.append('<td><a href="' + '/apps/donasi/view/' +
                                user
                                .id +
                                '" class="btn btn-primary"><i class="fas fa-clipboard-list"></i></a></td>'
                            );

                            row.append(
                                '<td style="display: flex; justify-content: center; align-items: center;"><a href="' +
                                '/apps/data_donasi/' + user.id +
                                '/edit' +
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
                            console.log(id_data_donasi);
                            deleteDataDonasi(id_data_donasi, $(this).closest('tr'));

                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            function deleteDataDonasi(id_data_donasi, row) {
                if (confirm('Apa Anda yakin ingin menghapus Data User ini?')) {
                    $.ajax({
                        url: '/api/admin/manajemen/data-donasi/delete/' + id_data_donasi,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Data Donasi deleted successfully');
                                // Remove the kegiatan row from the table
                                row.remove();

                            } else {
                                alert('Failed to delete Data Donasi');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('There has been a problem with your AJAX operation:', error);
                        }
                    });
                }
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
