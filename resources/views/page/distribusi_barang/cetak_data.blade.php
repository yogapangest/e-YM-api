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

    <table style="width: 100%; text-align: center;">
        <tr>
            <td style="width: 80%;">
                <p style="text-align: center;">
                    LAPORAN PERTANGGUNGJAWABAN KEGIATAN PROGRAM <br> YATIM MANDIRI CABANG BANYUWANGI
                </p>
            </td>
            <td style="width: 20%;">
                <img style="float: right; width: 300px; height: auto; max-width: 100%;"
                    src="{{ public_path('assets/img/e-ym/eym.png') }}" alt="Gambar" />
            </td>
        </tr>
    </table>

    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                <?php $firstItem = true; ?> <!-- Inisialisasi variabel $firstItem -->
                @foreach ($distribusi_barang as $barang)
                    @if ($firstItem)
                        <tr>
                            <td colspan="1" style="padding: 5px;">
                                Tanggal :
                                {{ \carbon\carbon::parse($barang->distribusi->tanggal)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px;">
                                Program : {{ $barang->distribusi->program->nama }}
                            </td>
                        </tr>
                        <?php $firstItem = false; ?> <!-- Set $firstItem menjadi false agar tidak diproses lagi -->
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

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
        <tbody>
            <?php $totalJumlah = 0; ?> <!-- Inisialisasi variabel totalJumlah -->
            @foreach ($distribusi_barang as $barang)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $barang->nama_barang }}</td>
                    <td class="text-center">{{ $barang->volume }}</td>
                    <td class="text-center">{{ $barang->satuan }}</td>
                    <td class="text-center">{{ number_format($barang->harga_satuan, 0, ',', '.') }}
                    </td>
                    <td class="text-center">{{ number_format($barang->jumlah, 0, ',', '.') }}</td>
                </tr>
                <?php $totalJumlah += $barang->jumlah; ?> <!-- Tambahkan nilai jumlah ke totalJumlah -->
            @endforeach
        </tbody>
    </table>

    <br>
    <div style="text-align: right;">Total Jumlah: {{ number_format($totalJumlah, 0, ',', '.') }}</div>
    <!-- Tampilkan total jumlah -->

    <div>
        <table style="width: 100%; border-collapse: collapse;">
            <tbody>
                <?php $firstItem = true; ?> <!-- Inisialisasi variabel $firstItem -->
                @foreach ($distribusi_barang as $barang)
                    @if ($firstItem)
                        <tr>
                            <td colspan="1" style="padding: 5px;">
                                Anggaran
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px;">
                                Dropingan : Rp. {{ number_format($barang->distribusi->anggaran, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px;">
                                Total Pengeluaran : Rp.
                                {{ number_format($barang->distribusi->pengeluaran, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 50%; padding: 5px;">
                                Sisa : Rp. {{ number_format($barang->distribusi->sisa, 0, ',', '.') }}
                            </td>
                        </tr>
                        <?php $firstItem = false; ?> <!-- Set $firstItem menjadi false agar tidak diproses lagi -->
                    @endif
                @endforeach
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
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Neni Nur Aini, S.Sos.)
                <div class="tanda_tangan_line">__________________</div>
                Lead Program
            </td>
            <td style="text-align: center;">
                Mengetahui<br>
                Kepala Cabang,<br>
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
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                <div class="tanda-tangan-line" style="margin: 0 auto;"></div>
                (Khusnul Ma'arif)
                <div class="tanda_tangan_line">__________________</div>
                Admin Keuangan
            </td>
        </tr>
    </table>
</body>

</html>
