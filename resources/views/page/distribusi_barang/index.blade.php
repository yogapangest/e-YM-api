@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Data Barang | e-YM</title>
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

                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 id="nama_program"></h4>
                                        <h4 id="tanggal"></h4>
                                    </div>
                                    <div class="text-end">
                                        <a href="#" class="btn btn-round btn-danger mr-2">Cetak</a>
                                        <a id="tambah" href="#" class="btn btn-round btn-primary">Tambah</a>
                                        <form class="mt-2 mb-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary mb-6"><i
                                                            class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Volume</th>
                                            <th>Satuan</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>

                                        <tbody id="table-distribusi-barangs">
                                            {{-- data distribusi barang --}}
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


            var distribusiId = window.location.pathname.split('/').pop();

            $('#tambah').on('click', function() {
                var url = '/apps/distribusi_barang/create/' + distribusiId;
                window.location.href = url;

            });
            $.ajax({
                url: '/api/admin/manajemen/distribusi-barang/' + distribusiId,
                method: 'GET',
                success: function(data) {

                    var date = new Date(data.distribusi.tanggal);
                    var formattedDate = formatTanggal(date);

                    $('#nama_program').text('Daftar Data Barang : ' + data.program.nama_program);
                    $('#tanggal').text('Tanggal : ' + formattedDate);

                    if (Array.isArray(data.distribusibarangs)) {
                        var tableBody = $('#table-distribusi-barangs');

                        var index = 1;
                        // Iterasi setiap kegiatan dalam data
                        data.distribusibarangs.forEach(function(distribusibarangs) {
                            // Buat baris tabel baru
                            var row = $('<tr></tr>');

                            // Tambahkan data kolom
                            row.append('<td>' + index + '</td>');
                            row.append('<td>' + distribusibarangs.nama_barang + '</td>');
                            row.append('<td>' + distribusibarangs.volume + '</td>');
                            row.append('<td>' + distribusibarangs.satuan + '</td>');
                            row.append('<td>' + formatRupiah(distribusibarangs.harga_satuan) +
                                '</td>');
                            row.append('<td>' + formatRupiah(distribusibarangs.jumlah) +
                                '</td>');


                            row.append('<td><a href="' + '/apps/distribusi_barang/edit/' +
                                distribusibarangs.id +
                                '" class="mr-1 btn btn-primary">Edit</a><button data-id="' +
                                distribusibarangs.id +
                                '" class="btn btn-danger delete-button">Delete</button></td>'
                            );


                            // Tambahkan baris ke dalam tabel
                            tableBody.append(row);

                            index++;

                        });

                        $('.delete-button').on('click', function() {
                            var id_distribusibarangs = $(this).data('id');
                            console.log(id_distribusibarangs);
                            deletedistribusibarang(id_distribusibarangs, $(this).closest('tr'));

                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            function formatTanggal(date) {
                var bulan = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                var tanggal = date.getDate();
                var bulanNama = bulan[date.getMonth()];
                var tahun = date.getFullYear();
                return tanggal + ' ' + bulanNama + ' ' + tahun;
            }

            function formatRupiah(number) {
                return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function deletedistribusibarang(id_distribusibarangs, row) {
                if (confirm('Apa Anda yakin ingin menghapus kegiatan ini?')) {
                    $.ajax({
                        url: '/api/admin/manajemen/distribusi-barang/delete/' + id_distribusibarangs,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                alert('Distribusi barang deleted successfully');
                                // Remove the kegiatan row from the table
                                row.remove();

                            } else {
                                alert('Failed to delete distribusi barang');
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
