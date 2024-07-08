<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use App\Models\DistribusiBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Pastikan ini ada
use Carbon\Carbon;

use TCPDF;


class DistribusiBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($distribusi_id)
    {
        $data = [
            'distribusi' => Distribusi::findOrFail($distribusi_id),
            'distribusi_id' => $distribusi_id,
            'distribusi_barang' => DistribusiBarang::where('distribusi_id', $distribusi_id)->get(),
        ];

        return view('page.distribusi_barang.index', $data);
    }


   public function cetakPDF($distribusi_id)
{
    $distribusi_barang = DistribusiBarang::where('distribusi_id', $distribusi_id)->get();
    $distribusi = Distribusi::find($distribusi_id); // Mengambil data distribusi berdasarkan ID
    $program = $distribusi->program; // Mengakses relasi program dari distribusi
    // $tanggal = \Carbon\Carbon::parse($distribusi->tanggal)->translatedFormat('d F Y'); // Menggunakan tanggal dari tabel distribusi
    $tanggal = Carbon::now()->translatedFormat('d F Y');
    $namaProgram = $program->nama;

    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('Creator');
    $pdf->SetAuthor('Author');
    $pdf->SetTitle($namaProgram . ' - ' . $tanggal);
    $pdf->setPrintHeader(false);

    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 12);



    $html = view('page.distribusi_barang.cetak_data', compact('distribusi_barang'))->render();

    // Ubah path gambar ke path absolut
    $html = str_replace('src="{{ asset(', 'src="' . public_path(), $html);

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdfContent = $pdf->Output($namaProgram.'-'.$tanggal); // Simpan PDF ke dalam variabel $pdfContent

    // Tampilkan PDF dalam browser untuk review
    return response($pdfContent)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="laporan_data_barang.pdf"');
}

    /**
     * Store a newly created resource in storage.
     */

     public function create($distribusi_id)
    {
        return view('page.distribusi_barang.create', compact('distribusi_id'));
    }

    public function store(Request $request)
        {
            $request->validate([
                'distribusi_id' => 'required|exists:distribusis,id',
                'nama_barang' => 'required',
                'volume' => 'required|numeric',
                'satuan' => 'required',
                'harga_satuan' => 'required|numeric',
            ]);

            // Hitung total harga barang baru
            $harga_barang = $request->volume * $request->harga_satuan;

            // Ambil data distribusi dan anggarannya
            $distribusi = Distribusi::find($request->distribusi_id);
            $pengeluaran = $distribusi->pengeluaran;

            // Hitung total harga barang yang sudah ada di distribusi ini
            $total_harga_barang_sekarang = DistribusiBarang::where('distribusi_id', $request->distribusi_id)->sum(DB::raw('volume * harga_satuan'));

            // Periksa apakah total harga barang melebihi pengeluaran
            if (($total_harga_barang_sekarang + $harga_barang) > $pengeluaran) {
                return back()->withErrors(['total_harga' => 'Total Harga Barang Melebihi Pengeluaran Yang Tertulis.'])->withInput();
            }

            // Jika validasi lolos, simpan data
            DistribusiBarang::create([
                'distribusi_id' => $request->distribusi_id,
                'nama_barang' => $request->nama_barang,
                'volume' => $request->volume,
                'satuan' => $request->satuan,
                'harga_satuan' => $request->harga_satuan,
                'jumlah' => $harga_barang,
            ]);

        return redirect()->route('index.view.distribusibarang', $request->distribusi_id);
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $distribusiBarang = DistribusiBarang::findOrFail($id);
        return view('page.distribusi_barang.edit', compact('distribusiBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, $id)
{
    $request->validate([
        'distribusi_id' => 'required|exists:distribusis,id',
        'nama_barang' => 'required',
        'volume' => 'required|numeric',
        'satuan' => 'required',
        'harga_satuan' => 'required|numeric',
    ]);

    $distribusiBarang = DistribusiBarang::findOrFail($id);

    // Debugging
    // dd($request->all());

    $distribusiBarang->update([
        'distribusi_id' => $request->distribusi_id,
        'nama_barang' => $request->nama_barang,
        'volume' => $request->volume,
        'satuan' => $request->satuan,
        'harga_satuan' => $request->harga_satuan,
        'jumlah' => $request->volume * $request->harga_satuan,
    ]);

    return redirect()->route('index.view.distribusibarang', $request->distribusi_id)->with('success', 'Data barang berhasil diupdate.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $distribusiBarang = DistribusiBarang::findOrFail($id);

        // Lakukan penghapusan data distribusi barang
        $distribusiBarang->delete();

    return redirect()->back()->with('toast_success', 'Data barang berhasil dihapus.');
    }
}
