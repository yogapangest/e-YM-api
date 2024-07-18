<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Admin\ArsipController;
use App\Http\Controllers\API\Admin\ProgramController;
use App\Http\Controllers\API\Admin\CetakPdfController;
use App\Http\Controllers\API\Admin\DashboardController;
use App\Http\Controllers\API\User\FormDonasiController;
use App\Http\Controllers\API\Admin\DataBarangController;
use App\Http\Controllers\API\Admin\DataDonasiController;
use App\Http\Controllers\API\Admin\DistribusiController;
use App\Http\Controllers\API\Admin\JenisArsipController;
use App\Http\Controllers\API\Admin\RekapDonasiController;
use App\Http\Controllers\API\Home\LeandingPageController;
use App\Http\Controllers\Api\User\UpdateProfileController;
use App\Http\Controllers\API\Admin\KontenProgramController;
use App\Http\Controllers\API\Admin\DistribusiBarangController;
use App\Http\Controllers\API\Admin\KontenPenyaluranController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('leandingpage', [LeandingPageController::class, 'Leandingpage']);
Route::post('register', [AuthController::class, 'Register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){

    Route::get('dashboard', [DashboardController::class, 'index']);

    //manajemen program
    Route::get('manajemen/program', [ProgramController::class, 'index']);
    Route::post('manajemen/program', [ProgramController::class, 'store']);
    Route::get('manajemen/program/edit/{id}', [ProgramController::class, 'edit']);
    Route::put('manajemen/program/update/{id}', [ProgramController::class, 'update']);
    Route::delete('manajemen/program/delete/{id}', [ProgramController::class, 'destroy']);
});

Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen distribusi
    Route::get('manajemen/distribusi', [DistribusiController::class, 'index']);
    Route::post('manajemen/distribusi', [DistribusiController::class, 'store']);
    Route::get('manajemen/distribusi/edit/{id}', [DistribusiController::class, 'edit']);
    Route::put('manajemen/distribusi/update/{id}', [DistribusiController::class, 'update']);
    Route::delete('manajemen/distribusi/delete/{id}', [DistribusiController::class, 'destroy']);
});

Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen distribusi
    Route::get('manajemen/distribusi-barang/{distribusis_id}', [DistribusiBarangController::class, 'index']);
    Route::post('manajemen/distribusi-barang', [DistribusiBarangController::class, 'store']);
    Route::get('manajemen/distribusi-barang/edit/{id}', [DistribusiBarangController::class, 'edit']);
    Route::put('manajemen/distribusi-barang/update/{id}', [DistribusiBarangController::class, 'update']);
    Route::delete('manajemen/distribusi-barang/delete/{id}', [DistribusiBarangController::class, 'destroy']);
    //manajemen distribusi cetak pdf
    // Route::get('cetakpdf/{distribusis_id}', [CetakPdfController::class, 'cetakPDF2']);
    // Route::get('/cetak/{distribusis_id}', [DistribusiBarangController::class, 'cetakPDF']);

});


Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen Jenis Arsip
    Route::get('manajemen/jenis-arsip', [JenisArsipController::class, 'index']);
    Route::post('manajemen/jenis-arsip', [JenisArsipController::class, 'store']);
    Route::get('manajemen/jenis-arsip/edit/{id}', [JenisArsipController::class, 'edit']);
    Route::put('manajemen/jenis-arsip/update/{id}', [JenisArsipController::class, 'update']);
    Route::delete('manajemen/jenis-arsip/delete/{id}', [JenisArsipController::class, 'destroy']);
});

Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen arsip
    Route::get('manajemen/arsip', [ArsipController::class, 'index']);
    Route::post('manajemen/arsip', [ArsipController::class, 'store']);
    Route::get('manajemen/arsip/edit/{id}', [ArsipController::class, 'edit']);
    Route::put('manajemen/arsip/update/{id}', [ArsipController::class, 'update']);
    Route::delete('manajemen/arsip/delete/{id}', [ArsipController::class, 'destroy']);
});

Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen data donasi(tampilan di admin beberapa donasi)
    Route::get('manajemen/data-donasi', [DataDonasiController::class, 'index']);
    Route::post('manajemen/data-donasi', [DataDonasiController::class, 'store']);
    Route::get('manajemen/data-donasi/edit/{id}', [DataDonasiController::class, 'edit']);
    Route::put('manajemen/data-donasi/update/{id}', [DataDonasiController::class, 'update']);
    Route::delete('manajemen/data-donasi/delete/{id}', [DataDonasiController::class, 'destroy']);
});

Route::prefix('admin/')->middleware('auth:sanctum')->group(function (){
    //manajemen rekap donasi di halaman admin
    Route::get('manajemen/rekap-donasi/{id}', [RekapDonasiController::class, 'index']);
    Route::post('manajemen/rekap-donasi', [RekapDonasiController::class, 'store']);
    Route::get('manajemen/rekap-donasi/edit/{id}', [RekapDonasiController::class, 'edit']);
    Route::put('manajemen/rekap-donasi/update/{id}', [RekapDonasiController::class, 'update']);
    Route::delete('manajemen/rekap-donasi/delete/{id}', [RekapDonasiController::class, 'destroy']);
});

Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen Konten Program
    Route::get('manajemen/kontenprogram', [KontenProgramController::class, 'index']);
    Route::post('manajemen/kontenprogram', [KontenProgramController::class, 'store']);
    Route::get('manajemen/kontenprogram/edit/{id}', [KontenProgramController::class, 'edit']);
    Route::put('manajemen/kontenprogram/update/{id}', [KontenProgramController::class, 'update']);
    Route::delete('manajemen/kontenprogram/delete/{id}', [KontenProgramController::class, 'destroy']);
});
    Route::get('admin/manajemen/kontenprogram', [KontenProgramController::class, 'index']);

Route::prefix('admin/')->middleware('auth:sanctum')->middleware('auth:sanctum')->group( function (){
    //manajemen Konten Penyaluran
    Route::get('manajemen/kontenpenyaluran', [KontenPenyaluranController::class, 'index']);
    Route::post('manajemen/kontenpenyaluran', [KontenPenyaluranController::class, 'store']);
    Route::get('manajemen/kontenpenyaluran/edit/{id}', [KontenPenyaluranController::class, 'edit']);
    Route::put('manajemen/kontenpenyaluran/update/{id}', [KontenPenyaluranController::class, 'update']);
    Route::delete('manajemen/kontenpenyaluran/delete/{id}', [KontenPenyaluranController::class, 'destroy']);
});
    Route::get('admin/manajemen/kontenpenyaluran', [KontenPenyaluranController::class, 'index']);


//Controller User
Route::prefix('user/')->middleware('auth:sanctum')->group( function (){

    Route::get('dashboard', [DashboardController::class, 'index']);
    //manajemen data donasi
    Route::get('manajemen/formdonasi/{id_user}', [FormDonasiController::class, 'index']);
    Route::post('manajemen/formdonasi', [FormdonasiController::class, 'store']);
    Route::get('manajemen/formdonasi/edit/{id}', [FormdonasiController::class, 'edit']);
    Route::put('manajemen/formdonasi/update/{id}', [FormDonasiController::class, 'update']);
    Route::delete('manajemen/formdonasi/delete/{id}', [FormDonasiController::class, 'destroy']);
});

Route::prefix('user/')->middleware('auth:sanctum')->group(function (){
    //update Profile
    Route::get('update-profile/edit', [UpdateProfileController::class, 'edit']);
    Route::put('update-profile/update', [UpdateProfileController::class, 'update']);
});




/////////////////////////pending//////////////////////////////
Route::prefix('admin/')->middleware('auth:sanctum')->group( function (){
    //manajemen data barang
    Route::get('manajemen/databarang', [DataBarangController::class, 'index']);
    Route::post('manajemen/databarang', [DataBarangController::class, 'store']);
    Route::get('manajemen/databarang/edit/{id}', [DataBarangController::class, 'edit']);
    Route::put('manajemen/databarang/update/{id}', [DataBarangController::class, 'update']);
    Route::delete('manajemen/databarang/delete/{id}', [DataBarangController::class, 'destroy']);
});