<?php

namespace App\Http\Controllers\Administrator\Dashboard;

use App\Models\Arsip;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Donasi;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\BuktiDonasi;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
         $years = BuktiDonasi::selectRaw('YEAR(created_at) as year')
                    ->groupBy('year')
                    ->orderBy('year', 'desc')
                    ->pluck('year');


        // Mengambil data yang ada
        $totalDistribusi = Distribusi::count();
        $totalArsip = Arsip::count();
        $totalDonatur = User::count();

        $totalDonasi = BuktiDonasi::count();

        $totalProgram = Program::count();


        // Mengambil peran "guest"
        $guestRole = Role::where('name', 'guest')->first();

        // Menghitung jumlah pengguna dengan peran "guest"
        $totalGuest = 0;
        if ($guestRole) {
            $totalGuest = User::whereHas('roles', function ($query) use ($guestRole) {
                $query->where('role_id', $guestRole->id);
            })->count();
        }

        $user = auth()->user();
        $donasiPerBulan = collect();

    // Menghitung total donasi keseluruhan admin
        $totalDonasiAdmin = BuktiDonasi::sum('nominal');
        $totalDonasiAdminFormatted = number_format($totalDonasiAdmin, 0, ',', '.');

        if ($user) {
            // Menghitung total donasi per bulan untuk user yang login
            $donasiPerBulan = BuktiDonasi::where('users_id', $user->id)
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(nominal) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get()
                ->keyBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                });

            // Menghitung total donasi keseluruhan untuk user yang login
            $totalDonasi = BuktiDonasi::where('users_id', $user->id)->sum('nominal');
        }

        // Format total donasi ke format rupiah
        $totalDonasiFormatted = number_format($totalDonasi, 0, ',', '.');

        // Nama bulan dalam bahasa Indonesia
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Menyusun data untuk setiap bulan dalam setahun
        $currentYear = Carbon::now()->year;
        $donationData = [];
        foreach (range(1, 12) as $month) {
            $key = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            $donationData[] = isset($donasiPerBulan[$key]) ? $donasiPerBulan[$key]->total : 0;
        }

        //GRAFIK ADMIN
        // Ambil semua bulan dalam setahun
        $year = date('Y'); // Ambil tahun saat ini
        $allMonths = range(1, 12);

        // Ambil data total donasi per bulan dari database untuk tahun ini
        $monthlyDonations = BuktiDonasi::selectRaw('COALESCE(SUM(nominal), 0) as total, MONTH(created_at) as month')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Indeks ulang array $monthlyDonations berdasarkan bulan
        $monthlyDonationsIndexed = $monthlyDonations->keyBy('month');

        // Persiapkan array untuk menyimpan total donasi per bulan
        $monthlyDonationsFinal = [];

        // Loop melalui semua bulan dalam setahun
        foreach ($allMonths as $month) {
            // Cek apakah data untuk bulan ini ada dalam $monthlyDonationsIndexed
            if (isset($monthlyDonationsIndexed[$month])) {
                $monthlyDonationsFinal[] = $monthlyDonationsIndexed[$month]->total;
            } else {
                // Jika tidak ada data untuk bulan ini, masukkan nilai 0
                $monthlyDonationsFinal[] = 0;
            }
        }

        // Format total donasi per bulan ke format rupiah
        $monthlyDonationsFormatted = collect($monthlyDonationsFinal)->map(function ($donation) {
            return number_format($donation, 0, ',', '.');
        });

        // Siapkan data untuk dimasukkan ke dalam grafik
        $donationDataAdmin = $monthlyDonationsFinal;


        return view('administrator.dashboard', compact('totalDistribusi', 'totalDonatur', 'totalArsip', 'totalProgram', 'totalGuest', 'totalDonasiFormatted', 'donationData', 'months','totalDonasiAdmin','totalDonasiAdminFormatted','monthlyDonations','donationDataAdmin','years'));
    }

 }