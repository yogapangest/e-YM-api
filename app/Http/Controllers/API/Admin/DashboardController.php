<?php

namespace App\Http\Controllers\API\Admin;

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

        $totalDistribusi = Distribusi::count();
        $totalArsip = Arsip::count();
        $totalDonatur = User::count();
        $totalDonasi = BuktiDonasi::count();
        $totalProgram = Program::count();

        $totalGuest = User::where('role','User')->count();
        // dd($totalGuest);

        $user = auth()->user();
        $donasiPerBulan = collect();
        $totalDonasiAdmin = BuktiDonasi::sum('nominal');
        $totalDonasiAdminFormatted = number_format($totalDonasiAdmin, 0, ',', '.');

        if ($user) {
            $donasiPerBulan = BuktiDonasi::where('users_id', $user->id)
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(nominal) as total')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get()
                ->keyBy(function ($item) {
                    return $item->year . '-' . str_pad($item->month, 2, '0', STR_PAD_LEFT);
                });

            $totalDonasi = BuktiDonasi::where('users_id', $user->id)->sum('nominal');
        }

        $totalDonasiFormatted = number_format($totalDonasi, 0, ',', '.');

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $currentYear = Carbon::now()->year;
        $donationData = [];
        foreach (range(1, 12) as $month) {
            $key = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
            $donationData[] = isset($donasiPerBulan[$key]) ? $donasiPerBulan[$key]->total : 0;
        }

        $year = date('Y');
        $allMonths = range(1, 12);

        $monthlyDonations = BuktiDonasi::selectRaw('COALESCE(SUM(nominal), 0) as total, MONTH(created_at) as month')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyDonationsIndexed = $monthlyDonations->keyBy('month');
        $monthlyDonationsFinal = [];
        foreach ($allMonths as $month) {
            $monthlyDonationsFinal[] = isset($monthlyDonationsIndexed[$month]) ? $monthlyDonationsIndexed[$month]->total : 0;
        }

        $monthlyDonationsFormatted = collect($monthlyDonationsFinal)->map(function ($donation) {
            return number_format($donation, 0, ',', '.');
        });

        $donationDataAdmin = $monthlyDonationsFinal;

        return response()->json([
            'totalDistribusi' => $totalDistribusi,
            'totalArsip' => $totalArsip,
            'totalDonatur' => $totalDonatur,
            'totalProgram' => $totalProgram,
            'totalGuest' => $totalGuest,
            'totalDonasiFormatted' => $totalDonasiFormatted,
            'donationData' => $donationData,
            'months' => $months,
            'totalDonasiAdmin' => $totalDonasiAdmin,
            'totalDonasiAdminFormatted' => $totalDonasiAdminFormatted,
            'monthlyDonations' => $monthlyDonations,
            'donationDataAdmin' => $donationDataAdmin,
            'years' => $years,
        ]);
        // return response()->json([
        //     'totalDistribusi' => 22,
        //     'totalArsip' => 1,
        //     'totalDonatur' => 4,
        //     'totalProgram' => $totalProgram,
        //     'totalGuest' => $totalGuest,
        //     'totalDonasiFormatted' => $totalDonasiFormatted,
        //     'donationData' => $donationData,
        //     'months' => $months,
        //     'totalDonasiAdmin' => $totalDonasiAdmin,
        //     'totalDonasiAdminFormatted' => $totalDonasiAdminFormatted,
        //     'monthlyDonations' => $monthlyDonations,
        //     'donationDataAdmin' => $donationDataAdmin,
        //     'years' => $years,
        // ]);
    }
}