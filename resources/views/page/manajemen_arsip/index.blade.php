@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Arsip | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
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
                                <h4>Daftar Arsip</h4>
                                <div class="card-header-form">
                                    <div class="ml-auto mb-2">
                                        <a href="{{ route('index.create.arsip') }}" style="float: right;"
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
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Program</th>
                                                <th>Jenis Arsip</th>
                                                <th>File</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-arsip">
                                            {{-- Data Arsip akan dimasukkan di sini --}}
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
    {{-- Datatable JS --}}
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/modules-datatables.js') }}"></script>

    {{-- Modal JS --}}
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    {{-- Custom Script --}}
    {{-- Script --}}
    <script>
        $(document).ready(function() {
            // Panggil fungsi untuk memuat data arsip pertama kali
            loadArsipData();

            // Fungsi untuk memuat ulang data arsip
            function loadArsipData() {
                $.ajax({
                    url: '/api/admin/manajemen/arsip',
                    method: 'GET',
                    success: function(data) {

                        if (Array.isArray(data.arsip)) {
                            var tableBody = $('#table-arsip');
                            tableBody.empty(); // Bersihkan isi tabel sebelum memuat data baru

                            var index = 1;
                            // Iterasi setiap arsip dalam data
                            data.arsip.forEach(function(arsip) {
                                // Buat baris tabel baru
                                var row = $('<tr></tr>');

                                // Tambahkan data kolom
                                row.append('<td>' + index + '</td>');
                                row.append('<td>' + arsip.program.nama_program + '</td>');
                                row.append('<td>' + arsip.jenis_arsip.nama_arsip + '</td>');

                                var fileUrl = arsip.file; // URL file

                                if (!fileUrl) {
                                    row.append('<td>' + null + '</td>');
                                } else {
                                    // Tentukan tipe file berdasarkan ekstensi
                                    var fileExtension = fileUrl.split('.').pop().toLowerCase();

                                    if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                        // Jika file gambar, buat elemen img
                                        row.append('<td><img src="' + '/file/arsip/' + fileUrl +
                                            '" alt="' + arsip.file +
                                            '" style="width: 70px; height: auto; border-radius: 0;"></td>'
                                        );
                                    } else if (fileExtension === 'pdf') {
                                        // Jika file PDF, buat link untuk mengunduh
                                        row.append('<td><a href="' + '/file/arsip/' + fileUrl +
                                            '" class="btn btn-primary"><i class="fas fa-file"></i></a></td>'
                                        );
                                    }
                                }

                                row.append(
                                    '<td style="display: flex; justify-content: center; align-items: center;"><a href="' +
                                    '/apps/arsip/' + arsip.id +
                                    '/edit' +
                                    '" class="mr-1 btn btn-primary"><i class="fas fa-edit"></i></a><button data-id="' +
                                    arsip.id +
                                    '" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button></td>'
                                );

                                // Tambahkan baris ke dalam tabel
                                tableBody.append(row);

                                index++;
                            });

                            $('.delete-button').on('click', function() {
                                var id_arsip = $(this).data('id');
                                deleteArsip(id_arsip, $(this).closest('tr'));
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('There has been a problem with your AJAX operation:', error);
                    }
                });
            }

            // Fungsi untuk menghapus arsip
            function deleteArsip(id_arsip, row) {
                if (confirm('Apa Anda yakin ingin menghapus arsip ini?')) {
                    $.ajax({
                        url: '/api/admin/manajemen/arsip/delete/' + id_arsip,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Arsip berhasil dihapus');
                                // Hapus baris arsip dari tabel
                                row.remove();
                            } else {
                                alert('Gagal menghapus arsip');
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
