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
            /* Mengatur tampilan body agar konten berada di tengah */
        }

        .logo {
            margin-top: 20px;
            /* Atur jarak antara logo dan judul */
            margin-right: auto;
            /* Geser ke sisi kanan */
            margin-left: auto;
            /* Geser ke sisi kiri */
            float: right;
            /* Mengatur gambar agar berada di sebelah kanan */
            width: 50px;
            /* Atur lebar gambar */
            height: auto;
            /* Biarkan tinggi gambar disesuaikan dengan lebar */
        }

        .judul {
            text-align: center;
            /* Atur judul menjadi di tengah halaman */
        }

        th {
            background-color: rgb(33, 248, 33);
            /* Atur warna latar belakang hijau untuk header tabel */
            color: black;
            /* Atur warna teks putih untuk kontras dengan latar belakang */
            text-align: center;
        }

        td.text-center {
            text-align: center;
            /* Atur teks di sel tabel menjadi di tengah */
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
            /* justify-content: space-between; */
            flex-direction: column;
            align-items: center;

            /* margin-top: 20px;
            width: 100%; */
        }

        .tanda-tangan-box {
            /* width: 45%; */
            text-align: center;
            flex-basis: 50%;
        }

        /* .tanda-tangan-left {
            text-align: left;
        } */

        .tanda-tangan-line {
            /* border-top: 1px solid black; */
            margin-top: 10px;
            width: 50%;
            margin-left: auto;
            /* Mengatur garis berada di ujung kanan */
            margin-right: auto;
            /* max-width: 100px; */
            /* Atur panjang maksimum border agar tidak terlalu panjang */
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <button id="cetak" href="#" class="btn btn-primary">Unduh
            Laporan</button>
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
    <!-- Tampilkan total jumlah -->

    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <tbody id="data-anggaran">
                <!-- Data anggaran akan diisi melalui JavaScript -->
            </tbody>
        </table>
    </div>

    <table class="tanggal">
        <div class="tanggal-box tanggal-right">
            Banyuwangi, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
        </div>
    </table>
    <!-- Tanda Tangan -->

    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="text-align: center;">
                <br><br>
                Admin LPP,<br>
                <br><br><br><br>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Neni Nur Aini, S.Sos.)
                <div class="tanda_tangan_line">__________________</div>
                Lead Program
            </td>
            <td style="text-align: center;">
                Mengetahui<br>
                Kepala Cabang,<br>
                <br><br><br><br>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Priyo Sigit Purnomo,S.Kom.)
                <div class="tanda_tangan_line">__________________</div>
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
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Khusnul Ma'arif)
                <div class="tanda_tangan_line">__________________</div>
                Admin Keuangan
            </td>
        </tr>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            var distribusiId = window.location.pathname.split('/').pop();

            document.getElementById('cetak').addEventListener('click', function() {
                var url = '/apps/cetak/' + distribusiId;
                window.location.href = url;
            });
        });
        // Ambil data dari API menggunakan fetch
        var distribusiId = window.location.pathname.split('/').pop();
        fetch('/api/admin/manajemen/distribusi-barang/' + distribusiId, {
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
                    <td class="text-center">${barang.harga_satuan}</td>
                    <td class="text-center">${barang.jumlah}</td>
                </tr>
            `;
                    totalJumlah += parseInt(barang.jumlah);
                });
                document.getElementById('data-barang').innerHTML = dataBarangHtml;
                document.getElementById('total-jumlah').textContent = totalJumlah.toLocaleString();

                // Isi informasi distribusi (tanggal, program, anggaran, pengeluaran, sisa)
                let dataAnggaranHtml = '';
                if (data.distribusi) {
                    dataAnggaranHtml += `
                <tr>
                    <td colspan="6" style="padding: 5px; text-align: left;">
                        Tanggal : ${data.distribusi.tanggal}
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
    </script>
</body>

</html>
