@extends('administrator.layouts.app')

@section('title')
    <title>Daftar Data Barang | e-YM</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }} ">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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
                                        <a href="#" id="cetak" class="btn btn-round btn-danger mr-2">Cetak</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script>
    <script>
        $(document).ready(function() {

            var distribusiId = window.location.pathname.split('/').pop();

            $('#tambah').on('click', function() {
                var url = '/apps/distribusi_barang/create/' + distribusiId;
                window.location.href = url;
            });

            $('#cetak').on('click', function() {
                var url = '/admin/manajemen/distribusi-barang/cetak/' + distribusiId;
                window.open(url, '_blank');
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
                        var totalJumlah = 0;

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

                            row.append(
                                '<td class="d-flex align-items-center"><a href="/apps/distribusi_barang/edit/' +
                                distribusibarangs.id +
                                '" class="mr-1 btn btn-primary"><i class="fas fa-edit"></i></a><button data-id="' +
                                distribusibarangs.id +
                                '" class="btn btn-danger delete-button"><i class="fas fa-trash-alt"></i></button></td>'
                            );

                            // Tambahkan baris ke dalam tabel
                            tableBody.append(row);

                            // Tambahkan ke total jumlah
                            totalJumlah += parseInt(distribusibarangs.jumlah);

                            index++;
                        });

                        $('.delete-button').on('click', function() {
                            var id_distribusibarangs = $(this).data('id');
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

        function generatePDF(data) {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            const tanggal = new Date(data.distribusi.tanggal).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });

            doc.setFontSize(12);

            // Menyiapkan data untuk tabel
            let tableData = [];
            data.distribusibarangs.forEach((barang, index) => {
                tableData.push([
                    index + 1,
                    barang.nama_barang,
                    barang.volume,
                    barang.satuan,
                    `Rp ${barang.harga_satuan.toLocaleString('id-ID')}`, // Format harga satuan
                    `Rp ${barang.jumlah.toLocaleString('id-ID')}` // Format jumlah
                ]);
            });

            // Menambahkan informasi tambahan ke dokumen
            doc.text('LAPORAN PERTANGGUNGJAWABAN KEGIATAN PROGRAM', 10, 10);
            doc.text('YATIM MANDIRI CABANG BANYUWANGI', 10, 20);
            doc.addImage('/assets/img/e-ym/eym.png', 'PNG', 150, 10, 50, 25);

            doc.text(`Tanggal: ${tanggal}`, 10, 40); // Adjust startY as needed
            doc.text(`Program: ${data.program.nama_program}`, 10, 50); // Adjust startY as needed

            // Menambahkan tabel ke dokumen
            doc.autoTable({
                startY: 60, // Adjust startY as needed
                head: [
                    ['No', 'Nama Barang', 'Volume', 'Satuan', 'Harga Satuan', 'Jumlah']
                ],
                body: tableData,
            });

            // Setelah tabel, tambahkan informasi tambahan lainnya
            const dropinganX = 140; // Posisi X untuk Dropingan
            const startYInfo = doc.autoTable.previous.finalY + 10; // Adjust the gap as needed

            doc.text(
                `Total Jumlah: Rp ${data.distribusibarangs.reduce((total, barang) => total + parseInt(barang.jumlah), 0).toLocaleString('id-ID')}`,
                dropinganX, startYInfo);

            doc.text(`Dropingan: Rp. ${data.distribusi.anggaran.toLocaleString('id-ID')}`, 10, startYInfo);
            doc.text(`Total Pengeluaran: Rp. ${data.distribusi.pengeluaran.toLocaleString('id-ID')}`, 10, startYInfo + 10);
            doc.text(`Sisa: Rp. ${data.distribusi.sisa.toLocaleString('id-ID')}`, 10, startYInfo + 20);

            // Tambahkan informasi tanggal dari tabel tanggal
            const tanggalSekarang = document.getElementById('tanggal-sekarang').textContent;
            const textWidth = doc.getTextWidth(`Banyuwangi, ${tanggalSekarang}`);
            const pageWidth = doc.internal.pageSize.width;
            const startX = pageWidth - textWidth - 10; // 10 adalah margin dari kanan

            doc.text(`Banyuwangi, ${tanggalSekarang}`, startX, startYInfo + 30);



            // Tambahkan tanda tangan dengan ukuran teks yang lebih kecil
            const lineMargin = 6;
            const fontSize = 12; // Ukuran font yang lebih kecil

            // Tanda tangan Neni Nur Aini
            const neniX = 15;
            const neniY = doc.lastAutoTable.finalY + 50;

            doc.setFontSize(fontSize);
            doc.text('Admin LPP,', neniX * 1.5, neniY);
            doc.text('(Neni Nur Aini, S.Sos.)', neniX, neniY + lineMargin * 4);
            doc.text('Lead Program', neniX, neniY + lineMargin * 5);

            // Tanda tangan Priyo Sigit Purnomo
            const sigitX = 135;
            const sigitY = doc.lastAutoTable.finalY + 50;

            doc.text('Mengetahui,', sigitX * 1.1, sigitY);
            doc.text('(Priyo Sigit Purnomo, S.Kom.)', sigitX, sigitY + lineMargin * 4);
            doc.text('Kepala Cabang', sigitX, sigitY + lineMargin * 5);

            // Tanda tangan Khusnul Ma'arif di tengah
            const centerWidth = doc.internal.pageSize.width / 2;
            const kasirX = centerWidth - doc.getTextWidth('Kasir,') / 2;
            const kasirY = doc.lastAutoTable.finalY + 60 + lineMargin * 3 + 20;

            doc.text('Kasir,', kasirX * 1.1, kasirY);
            doc.text('(Khusnul Ma\'arif)', kasirX, kasirY + lineMargin * 4);
            doc.text('Admin Keuangan', kasirX, kasirY + lineMargin * 5);

            // Simpan dokumen PDF dengan nama tertentu
            doc.save('Laporan_Pertanggungjawaban.pdf');
        }



        document.getElementById('cetakPDF').addEventListener('click', function() {
            var distribusiId = window.location.pathname.split('/').pop();

            // Mengambil data dari API menggunakan fetch
            fetch(`/api/admin/manajemen/distribusi-barang/${distribusiId}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    // Setelah data berhasil diambil, panggil fungsi generatePDF dengan data yang diterima
                    generatePDF(data);
                })
                .catch(error => console.error('Error:', error));
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
