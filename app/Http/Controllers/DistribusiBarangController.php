<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Distribusi;
use App\Models\DistribusiBarang;
use App\Models\Program;
use TCPDF;

class DistribusiBarangController extends Controller
{
    public function cetakPDF($distribusis_id)
    {
         try {
            // Ambil data distribusi dan data terkaitnya dari database
            $distribusi = Distribusi::with(['distribusiBarang', 'program'])->findOrFail($distribusis_id);
            return response()->json($distribusi);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengambil data', 'error' => $e->getMessage()], 500);
        }
    }
}
