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
    Route::get('register', function(){
        return view('auth.register');
    })->name('register');
    Route::post('registration',[AuthController::class, 'registration'])->name('registration');
});

Route::get('/',[HomeController::class, 'index'])->name('home');

// Route::get('/admin/manajemen/distribusi-barang/cetak/data/baru/{distribusis_id}', function(){
//     dd('tes');
//     return view('page.distribusi_barang.cetak_data');
// });

Route::get('/admin/manajemen/distribusi-barang/cetak/{distribusis_id}', function(){
    return view('page.distribusi_barang.cetak_data');
});



Route::prefix('apps')->middleware(['auth:sanctum', 'CheckRole:Admin;User'])->group( function() {

    Route::get('dashboard',function(){
        return view('administrator.dashboard');
    })->name('apps.dashboard');

    //manajemen distribusi
    Route::get('/distribusi/view', function(){
        return view('page.manajemen_distribusi.index');
    })->name('index.view.distribusi');
    Route::get('/distribusi/create',function(){
        return view('page.manajemen_distribusi.create');
    })->name('index.create.distribusi');
    Route::get('/distribusi/{id_distribusi}/edit',function(){
        return view('page.manajemen_distribusi.edit');
    })->name('index.edit.distribusi');
    Route::get('/distribusi/search', [DistribusiController::class, 'search'])->name('index.search.distribusi');


    //manajemen distribusi_barang
    Route::get('/distribusi_barang/view/{id_distribusi}',function(){
        return view('page.distribusi_barang.index');
    })->name('index.view.distribusibarang');
    Route::get('/distribusi_barang/create/{id_distribusi}',function(){
        return view('page.distribusi_barang.create');
    })->name('index.create.distribusibarang');
    Route::get('/distribusi_barang/edit/{id_distribusi}', function(){
        return view('page.distribusi_barang.edit');
    })->name('index.edit.distribusibarang');

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
    // Route::get('/arsip/view', function(){
    //     return view('page.manajemen_arsip.index');
    // })->name('index.view');
    // Route::get('/arsip/create',function(){
    //     return view('page.manajemen_arsip.create');
    // })->name('index.create');
    // Route::get('/arsip/{id_jenisArsip}/edit',function(){
    //     return view('page.manajemen_arsip.edit');
    // })->name('index.edit');

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
    Route::get('/arsip/view',function(){
        return view('page.manajemen_arsip.index');
    })->name('index.view.arsip');
    Route::get('/arsip/create', function(){
        return view('page.manajemen_arsip.create');
    })->name('index.create.arsip');
    Route::get('/arsip/{id}/edit', function(){
        return view('page.manajemen_arsip.edit');
    })->name('index.edit.arsip');

    //form data donasi(admin)
    Route::get('/donasi/view/{user_id}', function(){
        return view('page.manajemen_donasi.show');
    })->name('form.show.donasi_admin');
    Route::get('/donasi/{user_id}/create', function(){
        return view('page.manajemen_donasi.formadmin');
    })->name('form.create.donasi_admin');
    Route::post('/donasi/{user_id}/store', [AdminDonasiController::class, 'storeform'])->name('form.store.donasi_admin');
    Route::get('/donasi/form/{id}/editform',function(){
        return view('page.manajemen_donasi.editadmin');
    })->name('form.edit.donasi_admin');
    Route::put('/donasi/form/{id}/updateform',[AdminDonasiController::class, 'updateform'])->name('form.update.donasi_admin');
    Route::delete('/donasi/form/{id}/destroy',[AdminDonasiController::class, 'destroy'])->name('form.destroy.donasi_admin');

    //form data donasi(guest)
    Route::get('/donasi/user/view', function(){
        return view('page.manajemen_donasi.index');
    })->name('form.index.donasi');
    Route::get('/donasi/user/form/create', function(){
        return view('page.manajemen_donasi.form');
    })->name('form.create.donasi');
    Route::get('/donasi/form/{id}/edit', [DonasiController::class, 'edit'])->name('form.edit.donasi');


    //manajemen data_donasi
    Route::get('/data_donasi/view',function(){
        return view('page.manajemen_data_donasi.index');
    })->name('index.view.datadonasi');
    Route::get('/data_donasi/create',function(){
        return view('page.manajemen_data_donasi.create');
    })->name('index.create.datadonasi');
    Route::get('/data_donasi/{id}/edit',function(){
        return view('page.manajemen_data_donasi.edit');
    })->name('index.edit.datadonasi');

    //rekap donasi
    Route::get('/rekap_donasi/view',function(){
        return view('page.manajemen_rekap_donasi.index');
    })->name('index.view.rekapdonasi');



    //manajemen data_user
    Route::get('/data_user/view',[DataUserController::class, 'index'])->name('index.view.datauser');
    Route::get('/data_user/create',[DataUserController::class, 'create'])->name('index.create.datauser');
    Route::post('/data_user/store',[DataUserController::class, 'store'])->name('index.store.datauser');
    Route::get('/data_user/{id_users}/edit',[DataUserController::class, 'edit'])->name('index.edit.datauser');
    Route::put('/data_user/{id_users}/update',[DataUserController::class, 'update'])->name('index.update.datauser');
    Route::delete('/data_user/{id_users}/destroy',[DataUserController::class, 'destroy'])->name('index.destroy.datauser');


    //profile
    Route::get('/profile/show/{id_user}',function(){
        return view('page.manajemen_profile.index');
    })->name('index.view.profile');
    Route::put('/ubah-profile/{id_user}/update',[ProfileController::class, 'update'])->name('index.update.profile');


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
    Route::get('/konten_program/view', function(){
        return view('page.konten_program.index');
    })->name('index.view.kprogram');
    Route::get('/konten_program/create',function(){
        return view('page.konten_program.create');
    })->name('index.create.kprogram');
    Route::get('/konten_program/{id}/edit',function(){
        return view('page.konten_program.edit');
    })->name('index.edit.kprogram');

    //logout
    Route::get('logout',[AuthController::class, 'logout'])->name('logout');
});