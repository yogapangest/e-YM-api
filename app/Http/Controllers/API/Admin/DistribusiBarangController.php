<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use App\Models\DistribusiBarang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use TCPDF;

class DistribusiBarangController extends Controller
{

    public function index($distribusis_id)
    {
        try {
            $distribusi = Distribusi::findOrFail($distribusis_id);
            $distribusibarangs = DistribusiBarang::where('distribusis_id', $distribusis_id)->get();
            $program = $distribusi->program->first();
            $url = '/admin/distribusibarangs';


            return response()->json([
                'status' => 'success',
                'message' => 'Get data distribusi barang successful',
                'distribusi' => $distribusi,
                'distribusibarangs' => $distribusibarangs,
                'program' => $program,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get distribusi barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validasi data yang diterima
            $validatedData = $request->validate([
                'distribusis_id' => 'required|exists:distribusis,id',
                'nama_barang' => 'required',
                'volume' => 'required|numeric',
                'satuan' => 'required', // Validasi khusus untuk field satuan
                'harga_satuan' => 'required|numeric',
            ]);

            // Hitung nilai untuk field "jumlah"
            $volume = floatval($validatedData['volume']);
            $harga_satuan = floatval($validatedData['harga_satuan']);
            $jumlah = $volume * $harga_satuan;

            // Tambahkan nilai "jumlah" ke dalam data yang divalidasi
            $validatedData['jumlah'] = $jumlah;

            // Ambil field anggaran dari tabel distribusi
            $distribusi = Distribusi::findOrFail($validatedData['distribusis_id']);
            $anggaran = floatval($distribusi->anggaran);

            // Periksa apakah total jumlah melebihi anggaran
            $totalJumlahDistribusiBarang = DistribusiBarang::where('distribusis_id', $validatedData['distribusis_id'])->sum('jumlah');

            if ($totalJumlahDistribusiBarang + $jumlah > $anggaran) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Total Harga Barang Melebihi Pengeluaran Yang Tertulis'
                ], 400);
            }

            // Simpan data distribusi barang ke database
            $distribusibarangs = DistribusiBarang::create($validatedData);
            $distribusi->update([
                'pengeluaran' => $totalJumlahDistribusiBarang + $jumlah,
                'sisa' => $anggaran -  $totalJumlahDistribusiBarang - $jumlah,
            ]);

            $url = '/admin/distribusibarangs';

            return response()->json([
                'status' => 'success',
                'message' => 'Add distribusi barang successful',
                'distribusibarangs' => $distribusibarangs,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add distribusi barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function edit($id)
    {
        try {
            $distribusibarangs = DistribusiBarang::with('Distribusi')->findOrFail($id);
            $url = sprintf('/admin/distribusibarangs/edit/%d', $id);

            return response()->json([
                'status' => 'success',
                'message' => 'Get distribusi barang successful',
                'distribusibarangs' => $distribusibarangs,
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get distribusi barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
{

    // dd($request);
    try {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'distribusis_id' => 'required',
            'nama_barang' => 'required',
            'volume' => 'required|numeric',
            'satuan' => 'required', // Validasi khusus untuk field satuan
            'harga_satuan' => 'required|numeric',
        ]);

        // Hitung nilai untuk field "jumlah"
        $volume = floatval($validatedData['volume']);
        $harga_satuan = floatval($validatedData['harga_satuan']);
        $jumlah = $volume * $harga_satuan;

        // Tambahkan nilai "jumlah" ke dalam data yang divalidasi
        $validatedData['jumlah'] = $jumlah;

        // Ambil field anggaran dari tabel distribusi
        $distribusi = Distribusi::findOrFail($validatedData['distribusis_id']);
        $anggaran = floatval($distribusi->anggaran);

        // Periksa apakah total jumlah melebihi anggaran
        $totalJumlahDistribusiBarang = DistribusiBarang::where('distribusis_id', $validatedData['distribusis_id'])->where('id', '!=', $id)->sum('jumlah');
        if ($totalJumlahDistribusiBarang + $jumlah > $anggaran) {
            return response()->json([
                'status' => 'error',
                'message' => 'Total Harga Barang Melebihi Pengeluaran Yang Tertulis'
            ], 400);
        }

        // Update data distribusi barang di database
        $distribusiBarang = DistribusiBarang::findOrFail($id);

        // dd($distribusi, $distribusiBarang);
        $distribusiBarang->update($validatedData);

        $url = sprintf('/apps/distribusi_barang/view/%d', $validatedData['distribusis_id']);

        return response()->json([
            'status' => 'success',
            'message' => 'Update distribusi barang successful',
            'distribusibarang' => $distribusiBarang,
            'url' => $url,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update distribusi barang',
            'error' => $e->getMessage()
        ], 500);
    }
}


    public function destroy($id)
    {
        try {
            $distribusibarangs = DistribusiBarang::findOrFail($id);

            if ($distribusibarangs->file) {
                File::delete(public_path('file/distribusibarangs/' . $distribusibarangs->file));
            }

            $distribusibarangs->delete();
            $url = '/admin/distribusibarangs';

            return response()->json([
                'status' => 'success',
                'message' => 'distribusi barang has been removed',
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove distribusi barang',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function cetakPDF($distribusis_id)
{
    try {
        // Mengambil data distribusi barang berdasarkan ID distribusi
        $distribusi_barang = DistribusiBarang::where('distribusis_id', $distribusis_id)->get();
        if ($distribusi_barang->isEmpty()) {
            return response()->json(['message' => 'Distribusi barang tidak ditemukan'], 404);
        }

        // Mengambil data distribusi berdasarkan ID
        $distribusi = Distribusi::find($distribusis_id);
        if (!$distribusi) {
            return response()->json(['message' => 'Distribusi tidak ditemukan'], 404);
        }

        // Mengakses relasi program dari distribusi
        $program = $distribusi->program;
        $tanggal = Carbon::now()->translatedFormat('d F Y');
        $namaProgram = $program->nama;

        // Menginisialisasi TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Creator');
        $pdf->SetAuthor('Author');
        $pdf->SetTitle($namaProgram . ' - ' . $tanggal);
        $pdf->setPrintHeader(false);

        // Menambahkan halaman baru dan mengatur font
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', '', 12);

        // Mengambil view dan mengubah path gambar ke path absolut
        $html = view('page.distribusi_barang.cetak_data', compact('distribusi_barang'))->render();
        $html = str_replace('src="{{ asset(', 'src="' . public_path(), $html);

        // Menulis HTML ke dalam PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Menyimpan PDF ke dalam variabel $pdfContent
        $pdfContent = $pdf->Output($namaProgram.'-'.$tanggal, 'S'); // 'S' untuk mengembalikan PDF sebagai string

        // Mengirimkan PDF sebagai respons untuk diunduh
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="laporan_data_barang.pdf"');
    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan saat menghasilkan PDF', 'error' => $e->getMessage()], 500);
    }
}



}