<?php

namespace App\Http\Controllers\API\Admin;

use PDF;
use Exception;
use Carbon\Carbon;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use App\Models\DistribusiBarang;
use App\Http\Controllers\Controller;

class CetakPdfController extends Controller
{
    public function cetakPDF($distribusis_id)
    {
        try {
            $distribusi = Distribusi::findOrFail($distribusis_id);
            $distribusibarangs = DistribusiBarang::where('distribusis_id', $distribusis_id)->get();
            $url = '/admin/distribusibarangs';

            return response()->json([
                'status' => 'success',
                'message' => 'Get data distribusi barang successful',
                'distribusi' => $distribusi,
                'distribusibarangs' => $distribusibarangs,
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


    public function cetakPDF2($distribusibarang_id)
{
    try {
        // Ambil data distribusi barang berdasarkan distribusi_id
        $distribusibarang_barang = DistribusiBarang::where('distribusi_id', $distribusibarang_id)->get();

        // Ambil data distribusi berdasarkan ID
        $distribusibarang = Distribusi::findOrFail($distribusibarang_id);

        // Mengambil relasi program dari distribusi
        $program = $distribusibarang->program;

        // Mengakses tanggal distribusi, menggunakan Carbon untuk format tanggal
        $tanggal = Carbon::now()->translatedFormat('d F Y');

        // Mengambil nama program dari relasi program
        $namaProgram = $program->nama;

        // Inisialisasi TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Creator');
        $pdf->SetAuthor('Author');
        $pdf->SetTitle($namaProgram . ' - ' . $tanggal);
        $pdf->setPrintHeader(false);
        $pdf->AddPage();
        $pdf->SetFont('Helvetica', '', 12);

        // Render view cetak_data.blade.php dengan data distribusi_barang
        $html = view('page.manajemen_data_barang.cetak_data', compact('distribusi_barang'))->render();

        // Ubah path gambar ke path absolut
        $html = str_replace('src="{{ asset(', 'src="' . public_path(), $html);

        // Tulis HTML ke PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF ke variabel $pdfContent
        $pdfContent = $pdf->Output($namaProgram . '-' . $tanggal, 'S');

        // Tampilkan PDF dalam bentuk base64 untuk review
        return response()->json([
            'status' => 'success',
            'message' => 'PDF successfully generated',
            'pdf' => base64_encode($pdfContent),
            'filename' => 'laporan_data_barang.pdf'
        ]);
    } catch (\Exception $e) {
        // Tangani error dengan mengembalikan response error
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to generate PDF',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
