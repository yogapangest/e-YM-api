<?php

namespace App\Http\Controllers\API\Home;

use Exception;
use Illuminate\Http\Request;
use App\Models\KontenProgram;
use App\Models\KontenPenyaluran;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class LeandingPageController extends Controller
{
    public function Leandingpage()
    {
        try {
            $kontenpenyalurans = KontenPenyaluran::all();
            $kontenprograms = KontenProgram::all();
            $url = '/apps/leandingpage';

            return response()->json([
                'status' => 'success',
                'message' => 'Get data leanding page successfull',
                'kontenpenyaluran' => $kontenpenyalurans,
                'kontenprogram' => $kontenprograms,
                'url' => $url,
            ]);
        } catch (Exception $e) {
            Log::error('Failed to get leanding page: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get leanding page',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
