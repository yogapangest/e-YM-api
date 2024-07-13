@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Donasi | e-YM</title>
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
                                <h4>Daftar Donasi</h4>
                                <div class="card-header-form">
                                    <div class="ml-auto mb-2">
                                        <a id="tambah" href="#" style="float: right;"
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
                                            <th>Tanggal</th>
                                            <th>Deskripsi</th>
                                            <th>Nominal</th>
                                            <th>File</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                        <tbody id="table-admin-rekap-donasi">
                                            {{-- admin data rekap donasi --}}
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

            var userId = window.location.pathname.split('/').pop();

            $('#tambah').on('click', function() {
                var url = '/apps/donasi/' + userId + '/create/';
                window.location.href = url;

            });

            // var userId = window.location.pathname.split('/').pop();
            $.ajax({
                url: '/api/admin/manajemen/rekap-donasi/' + userId,
                method: 'GET',
                success: function(data) {
                    console.log(data)
                    if (Array.isArray(data.donasi)) {
                        var tableBody = $('#table-admin-rekap-donasi');

                        var index = 1;
                        // Iterasi setiap kegiatan dalam data
                        data.donasi.forEach(function(donasi) {

                            // Misalkan `donasi` adalah objek yang berisi data donasi
                            var date = new Date(donasi.created_at);
                            var formattedDate = formatTanggal(date);
                            // Buat baris tabel baru
                            var row = $('<tr></tr>');

                            // Tambahkan data kolom
                            row.append('<td>' + index + '</td>');
                            row.append('<td>' + formattedDate + '</td>');
                            row.append('<td>' + donasi.deskripsi + '</td>');
                            row.append('<td>' + formatRupiah(donasi.nominal) + '</td>');


                            var fileUrl = donasi.file; // URL file

                            if (!fileUrl) {
                                fileUrl = null
                                row.append('<td>' + null + '</td>');

                            } else {
                                // Tentukan tipe file berdasarkan ekstensi
                                var fileExtension = fileUrl.split('.').pop().toLowerCase();

                                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                    // Jika file gambar, buat elemen img
                                    row.append('<td><img src="' + '/file/donasi/' + fileUrl +
                                        '" alt="' + program.file +
                                        '" style="width: 70px; height: auto; border-radius: 0;"></td>'
                                    );
                                } else if (fileExtension === 'pdf') {
                                    // Jika file PDF, buat link untuk mengunduh
                                    row.append('<td><a href="' + '/file/donasi/' + fileUrl +
                                        '" class="btn btn-primary"><i class="fas fa-file"></i></a></td>'
                                    );
                                }
                            }

                            row.append(
                                '<td style="display: flex; justify-content: center; align-items: center;"><a href="' +
                                '/apps/donasi/form/' + donasi.id +
                                '/editform' +
                                '" class="mr-1 btn btn-primary"><i class="fas fa-edit"></i></a><button data-id="' +
                                donasi.id +
                                '" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button></td>'
                            );


                            // Tambahkan baris ke dalam tabel
                            tableBody.append(row);

                            index++;

                        });

                        $('.delete-button').on('click', function() {
                            var id_rekap_admin = $(this).data('id');
                            console.log(id_rekap_admin);
                            deleteRekapAdmin(id_rekap_admin, $(this).closest('tr'));

                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            function formatRupiah(number) {
                // Ubah number menjadi string dan tambahkan Rp di depannya
                let formattedNumber = 'Rp ' + number.toString();

                // Tambahkan titik sebagai pemisah ribuan
                formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                return formattedNumber;
            }

            // Fungsi untuk format tanggal dan waktu
            function formatTanggal(date) {
                var bulan = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                var tanggal = date.getDate();
                var bulanNama = bulan[date.getMonth()];
                var tahun = date.getFullYear();
                var jam = date.getHours().toString().padStart(2, '0');
                var menit = date.getMinutes().toString().padStart(2, '0');
                var detik = date.getSeconds().toString().padStart(2, '0');
                return tanggal + ' ' + bulanNama + ' ' + tahun + ' ' + jam + ':' + menit + ':' + detik;
            }

            function deleteRekapAdmin(id_rekap_admin, row) {
                if (confirm('Apa Anda yakin ingin menghapus Rekap ini?')) {
                    $.ajax({
                        url: '/api/admin/manajemen/rekap-donasi/delete/' + id_rekap_admin,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('kegiatan deleted successfully');
                                // Remove the kegiatan row from the table
                                row.remove();

                            } else {
                                alert('Failed to delete kegiatan');
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
