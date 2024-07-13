<?php

namespace App\Http\Controllers\API\Admin;

use Exception;
use App\Models\User;
use App\Models\Arsip;
use App\Models\Program;
use App\Models\Distribusi;
use App\Models\BuktiDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    public function index()
{
    try {
        // Calculate necessary totals
        $totalDistribusi = Distribusi::count();
        $totalArsip = Arsip::count();
        $totalDonatur = User::count();
        $totalProgram = Program::count();

        // Count users with 'user' role
        $totalUser = User::where('role', 'user')->count();

        // Fetch authenticated user's donation data if available
        $user = auth()->user();
        $totalDonasi = 0;
        $totalDonasiFormatted = '0';
        $donationData = [];
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

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
            $totalDonasiFormatted = number_format($totalDonasi, 0, ',', '.');

            // Prepare donation data for each month in the current year
            $currentYear = Carbon::now()->year;
            foreach (range(1, 12) as $month) {
                $key = $currentYear . '-' . str_pad($month, 2, '0', STR_PAD_LEFT);
                $donationData[] = isset($donasiPerBulan[$key]) ? $donasiPerBulan[$key]->total : 0;
            }
        }

        // Calculate total donations by month for admin
        $year = date('Y');
        $allMonths = range(1, 12);
        $monthlyDonations = BuktiDonasi::selectRaw('COALESCE(SUM(nominal), 0) as total, MONTH(created_at) as month')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $monthlyDonationsFinal = [];
        foreach ($allMonths as $month) {
            $monthlyDonationsFinal[] = isset($monthlyDonations[$month]) ? $monthlyDonations[$month]->total : 0;
        }
        // total setahun
        $totalDonasiKeseluruhan = array_sum($monthlyDonationsFinal);
        $totalDonasiKeseluruhanFormatted = number_format($totalDonasiKeseluruhan, 0, ',', '.');


        $monthlyDonationsFormatted = collect($monthlyDonationsFinal)->map(function ($donation) {
            return number_format($donation, 0, ',', '.');
        });


        // Prepare data for admin dashboard
        $rekapDonasi = $monthlyDonationsFinal;

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Data retrieved successfully',
            'totals' => [
                'totalDistribusi' => $totalDistribusi,
                'totalArsip' => $totalArsip,
                'totalDonatur' => $totalDonatur,
                'totalProgram' => $totalProgram,
                'totalUser' => $totalUser,
                'totalDonasi' => $totalDonasiFormatted,
            ],
            'donationData' => $donationData,
            'monthlyDonationsFinal'=>$monthlyDonationsFinal,
            'months' => $months,
            'adminData' => [
                'totalDonasiAdmin' => $totalDonasi,
                'totalDonasiAdminFormatted' => $totalDonasiFormatted,
                'monthlyDonations' => $monthlyDonations,
                'rekapDonasi' => $rekapDonasi,
                'monthlyDonationsFormatted' => $monthlyDonationsFormatted,
                'rekapDonasiAdmin'=>$monthlyDonationsFinal,
            ],
            'totalDonasiKeseluruhan' => $totalDonasiKeseluruhanFormatted,
        ]);
    } catch (Exception $e) {
        Log::error('Failed to fetch dashboard data: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to fetch dashboard data',
            'error' => $e->getMessage()
        ], Response::HTTP_INTERNAL_SERVER_ERROR); // Using HTTP status constant for 500 Internal Server Error
    }
}

}
