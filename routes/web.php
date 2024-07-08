<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\DataDonasiController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\JenisArsipController;
use App\Http\Controllers\AdminDonasiController;
use App\Http\Controllers\KontenProgramController;
use App\Http\Controllers\DistribusiBarangController;
use App\Http\Controllers\KontenPenyaluranController;
use App\Http\Controllers\Administrator\Dashboard\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::middleware('guest')->group( function() {
    Route::get('auth',[AuthController::class, 'index'])->name('auth');
    Route::post('login',[AuthController::class, 'login'])->name('login');
    Route::get('register',[AuthController::class, 'register'])->name('register');
    Route::post('registration',[AuthController::class, 'registration'])->name('registration');
});

Route::get('/',[HomeController::class, 'index'])->name('home');

Route::prefix('apps')->middleware(['auth:sanctum', 'CheckRole:Admin;User'])->group( function() {
    Route::get('dashboard',function(){
        return view('administrator.dashboard');
    })->name('apps.dashboard');

    //manajemen distribusi
    Route::get('/distribusi/view',[DistribusiController::class, 'index'])->name('index.view.distribusi');
    Route::get('/distribusi/create',[DistribusiController::class, 'create'])->name('index.create.distribusi');
    Route::post('/distribusi/store',[DistribusiController::class, 'store'])->name('index.store.distribusi');
    Route::get('/distribusi/{id_distribusi}/edit',[DistribusiController::class, 'edit'])->name('index.edit.distribusi');
    Route::put('/distribusi/{id_distribusi}/update',[DistribusiController::class, 'update'])->name('index.update.distribusi');
    Route::delete('/distribusi/{id_distribusi}/destroy',[DistribusiController::class, 'destroy'])->name('index.destroy.distribusi');
    Route::get('/distribusi/search', [DistribusiController::class, 'search'])->name('index.search.distribusi');


    //manajemen distribusi_barang
    Route::get('/distribusi_barang/view/{id_distribusi}',[DistribusiBarangController::class, 'index'])->name('index.view.distribusibarang');
    Route::get('/distribusi_barang/create/{id_distribusi}',[DistribusiBarangController::class, 'create'])->name('index.create.distribusibarang');
    Route::post('/distribusi_barang/store/{id_distribusi}',[DistribusiBarangController::class, 'store'])->name('index.store.distribusibarang');
    Route::get('/distribusi_barang/edit/{id_distribusi}',[DistribusiBarangController::class, 'edit'])->name('index.edit.distribusibarang');
    Route::put('/distribusi_barang/update/{id_distribusi}',[DistribusiBarangController::class, 'update'])->name('index.update.distribusibarang');
    Route::delete('/distribusi_barang/destroy/{id_distribusi}',[DistribusiBarangController::class, 'destroy'])->name('index.destroy.distribusibarang');

    // manajemen program
    Route::get('/program/view',function(){
        return view('page.manajemen_program.index');
    })->name('index.view.program');
    Route::get('/program/create',function(){
        return view('page.manajemen_program.create');
    })->name('index.create.program');
    Route::get('/program/{id_program}/edit',function(){
        return view('page.manajemen_program.edit');
    })->name('index.edit.program');

    //manajemen arsip
    Route::get('/arsip/view', function(){
        return view('page.manajemen_arsip.index');
    })->name('index.view');
    Route::get('/arsip/create',function(){
        return view('page.manajemen_arsip.create');
    })->name('index.create');
    Route::get('/arsip/{id_jenisArsip}/edit',function(){
        return view('page.manajemen_arsip.edit');
    })->name('index.edit');

    //manajemen jenis arsip
    Route::get('/jenis-arsip/view', function(){
        return view('page.manajemen_jenis_arsip.index');
    })->name('index.view');
    Route::get('/jenis-arsip/create',function(){
        return view('page.manajemen_jenis_arsip.create');
    })->name('index.create');
    Route::get('/jenis-arsip/{id_jenisArsip}/edit',function(){
        return view('page.manajemen_jenis_arsip.edit');
    })->name('index.edit');

    //manajemen arsip
    Route::get('/arsip/view',[ArsipController::class, 'index'])->name('index.view.arsip');
    Route::get('/arsip/create',[ArsipController::class, 'create'])->name('index.create.arsip');
    Route::post('/arsip/store',[ArsipController::class, 'store'])->name('index.store.arsip');
    Route::get('/arsip/{id}/edit',[ArsipController::class, 'edit'])->name('index.edit.arsip');
    Route::put('/arsip/{id}/update',[ArsipController::class, 'update'])->name('index.update.arsip');
    Route::delete('/arsip/{id}/destroy',[ArsipController::class, 'destroy'])->name('index.destroy.arsip');

    //form data donasi(admin)
    Route::get('/donasi/{user_id}', [AdminDonasiController::class, 'show'])->name('form.show.donasi_admin');
    Route::get('/donasi/{user_id}/create', [AdminDonasiController::class, 'createform'])->name('form.create.donasi_admin');
    Route::post('/donasi/{user_id}/store', [AdminDonasiController::class, 'storeform'])->name('form.store.donasi_admin');
    Route::get('/donasi/form/{id}/editform',[AdminDonasiController::class, 'editform'])->name('form.edit.donasi_admin');
    Route::put('/donasi/form/{id}/updateform',[AdminDonasiController::class, 'updateform'])->name('form.update.donasi_admin');
    Route::delete('/donasi/form/{id}/destroy',[AdminDonasiController::class, 'destroy'])->name('form.destroy.donasi_admin');

    //form data donasi(guest)
    Route::get('/donasi/user/view', [DonasiController::class, 'index'])->name('form.index.donasi');
    Route::get('/donasi/user/form/create', [DonasiController::class, 'create'])->name('form.create.donasi');
    Route::post('/donasi/user/form/store', [DonasiController::class, 'store'])->name('form.store.donasi');
    Route::get('/donasi/form/{id}/edit', [DonasiController::class, 'edit'])->name('form.edit.donasi');
    Route::put('/donasi/form/{id}/update', [DonasiController::class, 'update'])->name('form.update.donasi');


    //manajemen data_donasi
    Route::get('/data_donasi/view',[DataDonasiController::class, 'index'])->name('index.view.datadonasi');
    Route::get('/data_donasi/create',[DataDonasiController::class, 'create'])->name('index.create.datadonasi');
    Route::post('/data_donasi/store',[DataDonasiController::class, 'store'])->name('index.store.datadonasi');
    Route::get('/data_donasi/{id}/edit',[DataDonasiController::class, 'edit'])->name('index.edit.datadonasi');
    Route::put('/data_donasi/{id}/update',[DataDonasiController::class, 'update'])->name('index.update.datadonasi');
    Route::get('/data_donasi/{id_donasi}/destroy',[DataDonasiController::class, 'destroy'])->name('index.destroy.datadonasi');

    //manajemen data_user
    Route::get('/data_user/view',[DataUserController::class, 'index'])->name('index.view.datauser');
    Route::get('/data_user/create',[DataUserController::class, 'create'])->name('index.create.datauser');
    Route::post('/data_user/store',[DataUserController::class, 'store'])->name('index.store.datauser');
    Route::get('/data_user/{id_users}/edit',[DataUserController::class, 'edit'])->name('index.edit.datauser');
    Route::put('/data_user/{id_users}/update',[DataUserController::class, 'update'])->name('index.update.datauser');
    Route::delete('/data_user/{id_users}/destroy',[DataUserController::class, 'destroy'])->name('index.destroy.datauser');


    //profile
    Route::get('/profile/show/{id_user}',[ProfileController::class, 'show'])->name('index.view.profile');
    Route::put('/ubah-profile/{id_user}/update',[ProfileController::class, 'update'])->name('index.update.profile');

    //cetak lpj
    Route::get('/cetak/{distribusi_id}', [DistribusiBarangController::class, 'cetakPDF'])->name('cetak.pdf');

    //konten penyaluran
    Route::get('/konten_penyaluran/view',function(){
        return view('page.konten_penyaluran.index');
    })->name('index.view.penyaluran');
    Route::get('/konten_penyaluran/create',function(){
        return view('page.konten_penyaluran.create');
    })->name('index.create.penyaluran');
    Route::get('/konten_penyaluran/{id}/edit',function(){
        return view('page.konten_penyaluran.edit');
    })->name('index.edit.penyaluran');

    //konten program
    Route::get('/konten_program/index',[KontenProgramController::class, 'index'])->name('index.view.kprogram');
    Route::get('/konten_program/create',[KontenProgramController::class, 'create'])->name('index.create.kprogram');
    Route::post('/konten_program/store',[KontenProgramController::class, 'store'])->name('index.store.kprogram');
    Route::get('/konten_program/{id}/edit',[KontenProgramController::class, 'edit'])->name('index.edit.kprogram');
    Route::put('/konten_program/{id}/update',[KontenProgramController::class, 'update'])->name('index.update.kprogram');
    Route::delete('/konten_program/{id}/destroy',[KontenProgramController::class, 'destroy'])->name('index.destroy.kprogram');

    //logout
    Route::get('logout',[AuthController::class, 'logout'])->name('logout');
});
