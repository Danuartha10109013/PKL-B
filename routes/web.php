<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FullCalenderController;
use App\Http\Controllers\KelolaAbsensiController;
use App\Http\Controllers\KelolaCutiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;



// Routes for authentication
Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


//auto Logout
Route::middleware([AutoLogout::class])->group(function () {

    //Profile
    Route::prefix('profile')->group(function () {
        Route::get('{id}',[ProfileController::class,'index'])->name('profile');
        Route::put('/update/{id}',[ProfileController::class,'update'])->name('profile.update');
    });

    // Admin routes group with middleware and prefix
    Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'admin'])->name('dashboard'); //not same

        // Manage Employees
        Route::prefix('kelolapegawai')->group(function () {
            Route::get('/',[PegawaiController::class,'index'])->name('kelolapegawai');
            Route::get('/active/{id}',[PegawaiController::class,'active'])->name('kelolapegawai.active');
            Route::get('/nonactive/{id}',[PegawaiController::class,'nonactive'])->name('kelolapegawai.nonactive');
            Route::post('/add',[PegawaiController::class,'add'])->name('kelolapegawai.add');
            Route::put('/edit/{id}',[PegawaiController::class,'update'])->name('kelolapegawai.edit');
            Route::get('/delete/{id}',[PegawaiController::class,'delete'])->name('kelolapegawai.delete');
        });
        Route::prefix('kabsensi')->group(function () {
            Route::get('/',[KelolaAbsensiController::class,'index'])->name('kabsensi');
            Route::get('/export',[KelolaAbsensiController::class,'export'])->name('kabsensi.export');
            Route::put('/konfirmasi/{id}',[KelolaAbsensiController::class,'confirm'])->name('kabsensi.konfirmasi');
        });

        Route::prefix('kcuti')->group(function () {
            Route::get('/',[KelolaCutiController::class,'index'])->name('kcuti');
            Route::put('/update/{id}',[KelolaCutiController::class,'update'])->name('kcuti.update');
            Route::get('/download/{id}',[KelolaCutiController::class,'download'])->name('kcuti.download');
            // Route::get('/download/{file}', function ($file) {
            //     $filePath = public_path('bukti/' . $file); // Adjust as needed
            
            //     if (file_exists($filePath)) {
            //         return response()->download($filePath);
            //     } else {
            //         abort(404, 'File not found.');
            //     }
            // })->name('download');
        });
    });

    //Pegawai
    Route::group(['prefix' => 'pegawai', 'middleware' => ['pegawai'], 'as' => 'pegawai.'], function () {

        Route::get('/', [DashboardController::class, 'pegawai'])->name('dashboard'); //not same

        Route::prefix('absensi')->group(function () {
            Route::get('/',[AbsensiController::class,'index'])->name('absensi');
            Route::get('/masuk',[AbsensiController::class,'masuk'])->name('absensi.masuk');
            Route::post('/storemasuk',[AbsensiController::class,'absensiMasuk'])->name('absensi.masuk.store');
            Route::get('/pulang',[AbsensiController::class,'pulang'])->name('absensi.pulang');
            Route::post('/storepulang',[AbsensiController::class,'absensiPulang'])->name('absensi.pulang.store');
        });
        Route::prefix('cuti')->group(function () {

            Route::get('/',[CutiController::class,'index'])->name('cuti');
            Route::post('/store',[CutiController::class,'store'])->name('cuti.store');
            //cc Calendar
            Route::controller(FullCalenderController::class)->group(function(){
                Route::get('fullcalender', 'index')->name('calendar');
                Route::post('fullcalenderAjax', 'ajax');
        });
   });
});
});