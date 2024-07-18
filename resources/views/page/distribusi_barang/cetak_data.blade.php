<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Barang</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo {
            margin-top: 20px;
            margin-right: auto;
            margin-left: auto;
            float: right;
            width: 50px;
            height: auto;
        }

        .judul {
            text-align: center;
        }

        th {
            background-color: rgb(33, 248, 33);
            color: black;
            text-align: center;
        }

        td.text-center {
            text-align: center;
        }

        .tanggal {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            width: 100%;
        }

        .tanggal-box {
            width: 45%;
            text-align: right;
        }

        .tanggal-right {
            text-align: right;
        }

        .tanda-tangan {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .tanda-tangan-box {
            text-align: center;
            flex-basis: 50%;
        }

        .tanda-tangan-line {
            margin-top: 10px;
            width: 50%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <button id="cetak" class="btn btn-primary">Unduh Laporan</button>
    </div>

    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="width: 80%;">
                <p style="text-align: center;">
                    LAPORAN PERTANGGUNGJAWABAN KEGIATAN PROGRAM <br> YATIM MANDIRI CABANG BANYUWANGI
                </p>
            </td>
            <td style="width: 20%;">
                <img style="float: right; width: 300px; height: auto; max-width: 100%;" src="/assets/img/e-ym/eym.png"
                    alt="Gambar" />
            </td>
        </tr>
    </table>

    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Volume</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody id="data-barang">
            <!-- Data barang akan diisi melalui JavaScript -->
        </tbody>
    </table>

    <br>
    <div style="text-align: right;">Total Jumlah: <span id="total-jumlah"></span></div>

    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <tbody id="data-anggaran">
                <!-- Data anggaran akan diisi melalui JavaScript -->
            </tbody>
        </table>
    </div>

    <table class="tanggal">
        <div class="tanggal-box tanggal-right">
            Banyuwangi, <span id="tanggal-sekarang"></span>
        </div>
    </table>

    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="text-align: center;">
                <br><br>
                Admin LPP,<br>
                <br><br><br><br>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Neni Nur Aini, S.Sos.)<br>
                Lead Program
            </td>
            <td style="text-align: center;">
                Mengetahui<br>
                Kepala Cabang,<br>
                <br><br><br><br>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Priyo Sigit Purnomo, S.Kom.)<br>
                Kepala Cabang
            </td>
        </tr>
    </table>

    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="text-align: center;">
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                Kasir,<br>
                <br><br><br><br>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Khusnul Ma'arif)<br>
                Admin Keuangan
            </td>
        </tr>
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.19/jspdf.plugin.autotable.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var distribusiId = window.location.pathname.split('/').pop();

            // Ambil data dari API menggunakan fetch
            fetch(`/api/admin/manajemen/distribusi-barang/${distribusiId}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    // Isi data barang
                    let dataBarangHtml = '';
                    let totalJumlah = 0;
                    data.distribusibarangs.forEach((barang, index) => {
                        dataBarangHtml += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td class="text-center">${barang.nama_barang}</td>
                            <td class="text-center">${barang.volume}</td>
                            <td class="text-center">${barang.satuan}</td>
                            <td class="text-center">Rp ${barang.harga_satuan.toLocaleString()}</td>
                            <td class="text-center">Rp ${barang.jumlah.toLocaleString()}</td>
                        </tr>
                    `;
                        totalJumlah += parseInt(barang.jumlah);
                    });
                    document.getElementById('data-barang').innerHTML = dataBarangHtml;
                    document.getElementById('total-jumlah').textContent = `Rp ${totalJumlah.toLocaleString()}`;

                    // Isi informasi distribusi (tanggal, program, anggaran, pengeluaran, sisa)
                    let dataAnggaranHtml = '';
                    if (data.distribusi) {
                        dataAnggaranHtml += `
                        <tr>
                            <td colspan="6" style="padding: 5px; text-align: left;">
                                Tanggal : ${new Date(data.distribusi.tanggal).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' })}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 5px; text-align: left;">
                                Program : ${data.program.nama_program}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding: 5px; text-align: left;">
                                Dropingan : Rp. ${data.distribusi.anggaran.toLocaleString()}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="padding: 5px; text-align: left;">
                                Total Pengeluaran : Rp. ${data.distribusi.pengeluaran.toLocaleString()}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding: 5px; text-align: left;">
                                Sisa : Rp. ${data.distribusi.sisa.toLocaleString()}
                            </td>
                        </tr>
                    `;
                    }
                    document.getElementById('data-anggaran').innerHTML = dataAnggaranHtml;
                })
                .catch(error => console.error('Error:', error));

            // Set tanggal sekarang
            document.getElementById('tanggal-sekarang').textContent = new Date().toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
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

            doc.text(`Tanggal: ${tanggal}`, 15, 40); // Adjust startY as needed
            doc.text(`Program: ${data.program.nama_program}`, 15, 48); // Adjust startY as needed

            // Menambahkan tabel ke dokumen
            doc.autoTable({
                startY: 55, // Adjust startY as needed
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
                dropinganX + 10, startYInfo);

            doc.text(`Dropingan: Rp. ${data.distribusi.anggaran.toLocaleString('id-ID')}`, 15, startYInfo);
            doc.text(`Total Pengeluaran: Rp. ${data.distribusi.pengeluaran.toLocaleString('id-ID')}`, 15, startYInfo + 8);
            doc.text(`Sisa: Rp. ${data.distribusi.sisa.toLocaleString('id-ID')}`, 15, startYInfo + 16);

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



        document.getElementById('cetak').addEventListener('click', function() {
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
</body>

</html>
