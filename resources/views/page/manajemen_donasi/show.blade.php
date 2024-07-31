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
                                <div class="card-header-form d-flex justify-content-between align-items-center">
                                    <a id="tambah" href="#" class="btn btn-round btn-primary mb-10">Tambah</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Deskripsi</th>
                                                <th>Nominal</th>
                                                <th>File</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
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

    <!-- Modal untuk menampilkan gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Lihat Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalImage" src="" alt="Gambar" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ZfXU5+uFbB2d9rDwH4d5/4wT+6l30e48Y2Uxl1V2V0t0R+G9Q3XdsWmj9n0wOjgV7" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            var userId = window.location.pathname.split('/').pop();

            $('#tambah').on('click', function() {
                var url = '/apps/donasi/' + userId + '/create/';
                window.location.href = url;
            });

            $.ajax({
                url: '/api/admin/manajemen/rekap-donasi/' + userId,
                method: 'GET',
                success: function(data) {
                    console.log(data)
                    if (Array.isArray(data.donasi)) {
                        var tableBody = $('#table-admin-rekap-donasi');
                        var index = 1;
                        data.donasi.forEach(function(donasi) {
                            var date = new Date(donasi.created_at);
                            var formattedDate = formatTanggal(date);
                            var row = $('<tr></tr>');
                            row.append('<td>' + index + '</td>');
                            row.append('<td>' + formattedDate + '</td>');
                            row.append('<td>' + donasi.deskripsi + '</td>');
                            row.append('<td>' + formatRupiah(donasi.nominal) + '</td>');

                            var fileUrl = donasi.file;
                            if (!fileUrl) {
                                row.append('<td>' + 'No file' + '</td>');
                            } else {
                                var fileExtension = fileUrl.split('.').pop().toLowerCase();
                                if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
                                    var imgElement = $('<img>', {
                                        src: '/file/donasi/' + fileUrl,
                                        alt: donasi.file,
                                        style: 'width: 35px; height: auto; border-radius: 0; cursor: pointer;',
                                        class: 'clickable-image'
                                    });
                                    row.append($('<td>').append(imgElement));
                                } else if (fileExtension === 'pdf') {
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

                            tableBody.append(row);
                            index++;
                        });

                        $(document).on('click', '.clickable-image', function() {
                            var imgSrc = $(this).attr('src');
                            $('#modalImage').attr('src', imgSrc);
                            var imageModal = new bootstrap.Modal(document.getElementById(
                                'imageModal'));
                            imageModal.show();
                        });

                        $('.delete-button').on('click', function() {
                            var id_rekap_admin = $(this).data('id');
                            deleteRekapAdmin(id_rekap_admin, $(this).closest('tr'));
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('There has been a problem with your AJAX operation:', error);
                }
            });

            function formatRupiah(number) {
                let formattedNumber = 'Rp ' + number.toString();
                formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                return formattedNumber;
            }

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
                            url: '/api/admin/manajemen/rekap-donasi/delete/' + id_rekap_admin,
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
                                        text: 'Data berhasil dihapus!'
                                    }).then(() => {
                                        row.remove();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: 'Data gagal dihapus!'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Terjadi kesalahan:', error);
                            }
                        });
                    }
                });
            }
        });
    </script>
@endsection
