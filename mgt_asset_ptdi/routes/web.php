<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Employee\OrganisasiController;
use App\Http\Controllers\Employee\JabatanController;
use App\Http\Controllers\Employee\DistributionController;

use App\Http\Controllers\Asset\KategoriController;
use App\Http\Controllers\Asset\SubKategoriController;
use App\Http\Controllers\Asset\DeviceController;
use App\Http\Controllers\Asset\AssetController;
use App\Http\Controllers\Pendanaan\PendanaanController;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\AuthController;

use Illuminate\Http\Request;

// ================================================================ AUTH ================================================================

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/', [AuthController::class, 'index']) ->name('auth.index');
Route::post('/auth/verify', [AuthController::class, 'verify']) ->name('auth.verify');
Route::get('/register', [AuthController::class, 'register']) ->name('auth.register');
Route::post('/register', [AuthController::class, 'verifyRegister']) ->name('auth.verifyRegister');


Route::get('/login/super', [AuthController::class, 'showLoginFormSuper'])->name('login-super');
Route::get('/register-super', [AuthController::class, 'registerSuper']) ->name('auth.registerSuper');
Route::post('/register-super', [AuthController::class, 'verifyRegisterSuper']) ->name('auth.verifyRegisterSuper');

Route::get('/auth/logout', [AuthController::class, 'logout']) ->name('auth.logout');

Route::get('password/reset', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');


Route::get('password-super/reset', [AuthController::class, 'showResetFormSuper'])->name('password.reset-super');
Route::post('password-super/reset', [AuthController::class, 'resetPasswordSuper'])->name('password.update-super');

Route::get('/choose-role', [AuthController::class, 'chooseRole'])->name('choose-role');
Route::post('/select-role', [AuthController::class, 'selectRole'])->name('role-selection');

// ================================================================ ADMIN ================================================================
Route::get('/dokumen/{filename}', function ($filename) {
    return response()->file(storage_path('app/public/dokumen/' . $filename));
})->name('dokumen.show');
Route::group(['middleware' => 'auth:admin'], function () {
    Route::put('/update-role/{role}', [AuthController::class, 'updateRole'])->name('update-role');
    Route::delete('/delete-role/{role}', [AuthController::class, 'deleteRole'])->name('delete-role');
    Route::get('/detail-notifikasi', [HomeController::class, 'detailNotifikasi'])->name('admin.detail-notifikasi');

    Route::get('/history-pengajuan', [DistributionController::class, 'historyPengajuan'])->name('history-pengajuan');
    Route::post('/update-status/{id}', [DistributionController::class, 'updateStatus'])->name('update.status');

    Route::get('/admin/dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');
    //Employee
    Route::get('/employee/searchOrg', [EmployeeController::class, 'searchOrg'])->name('employee.searchOrg');
    Route::get('/employee/{employee}/asset', [EmployeeController::class, 'detailAsset'])->name('detailAssetEmployee');
    Route::get('/import-excel', [EmployeeController::class, 'import_excel']);
    Route::post('/import-excel', [EmployeeController::class, 'import_excel_post']);

    Route::resource('/employee', EmployeeController::class);
    
    //Organisasi
    Route::resource('/organisasi', OrganisasiController::class);
    
    //Jabatan
    Route::resource('/jabatan', JabatanController::class);
    
    //Distribusi
    Route::get('/fetch-user-data', [DistributionController::class, 'fetchUserData'])->name('fetch-user-data');
    Route::get('/fetch-no_penyerahan', [DistributionController::class, 'fetchNoPenyerahan'])->name('fetchNoPenyerahan');
    Route::get('/fetch-device-data', [DistributionController::class, 'fetchDeviceData']);
    Route::get('/fetch-asset-data', [DistributionController::class, 'fetchAssetData'])->name('fetch-asset-data');
    
    Route::get('/distribusi/export', [DistributionController::class, 'export'])->name('asset.export');
    Route::delete('/distribusi/{distribusi}/asset/{asset}/destroy', [DistributionController::class, 'destroy']);
    Route::get('/distribusi/{nomor_penyerahan}/asset/{device}/edit', [DistributionController::class, 'editDevice'])->name('distribusi.asset.edit');
    Route::put('/distribusi/{nomor_penyerahan}/asset/{asset}', [DistributionController::class, 'updateDevice'])->name('distribusi.asset.update');
    
    Route::get('/distribusi/{distribusi}/pilihPengalihan', [DistributionController::class, 'pilihPengalihan'])->name('pilihPengalihan');
    Route::get('/distribusi/{distribusi}/detailAsset', [DistributionController::class, 'detailAsset'])->name('detailAsset');
    
    Route::get('/distribusi/{distribusi}/detail/{detail}/pengalihanAsset', [DistributionController::class, 'pengalihanAsset']);
    Route::put('/distribusi/{distribusi}/detail/{detail}/updatePengalihanAsset', [DistributionController::class, 'updatePengalihanAsset']);
    Route::delete('/distribusi/{distribusi}/asset/{asset}', [DistributionController::class, 'destroyDevice']);
    Route::delete('/distribusi/{nomor_penyerahan}/destroyDist', [DistributionController::class, 'destroyDistribution']);
    
    
    Route::get('/distribusi/{distribusi}/detail/{detail}/pengalihanDevice', [DistributionController::class, 'pengalihanDevice']);
    Route::put('/distribusi/{distribusi}/detail/{detail}/updatePengalihanDevice', [DistributionController::class, 'updatePengalihanDevice']);
    
    Route::get('/history', [DistributionController::class, 'history'])->name('history');
    Route::get('/historyAsset/{history}/{distribusi}', [DistributionController::class, 'detailHistoryAsset'])->name('distribusi.history.detail');
    Route::get('/historyDevice/{history}/{distribusi}', [DistributionController::class, 'detailHistoryDevice']);
    Route::get('/get-tipe-by-kategori/{idKategori}', [DistributionController::class, 'getTipeByKategori'])->name('getTipeByKategori');
    
    Route::post('/distribution-asset', [DistributionController::class, 'distAssetStore']);
    Route::get('/distribution-asset/create/{distribution}', [DistributionController::class, 'tambahAsset']);
    Route::post('/distribution-asset/create/{distribution}', [DistributionController::class, 'tambahDistribusiAsset']);

    
    Route::resource('/distribusi', DistributionController::class);

    // KATEGORI

    
    // SUB KATEGORI
    Route::get('/get-sub-by-kategori/{idKategori}', [SubKategoriController::class, 'getSubByKategori'])->name('getSubByKategori');

    // ASSETS
    Route::get('/get-device-by-kategori/{kategoriId}', [DeviceController::class, 'getDeviceByKategori']);
    Route::get('/get-device-rusak-by-kategori/{kategoriId}', [AssetController::class, 'getDevRusakByKategori']);
    Route::get('/assets/tambah-device', [DeviceController::class, 'viewTambahDevice'])->name('viewTambahDevice');
    Route::get('/asset/barang-rusak', [AssetController::class, 'viewBarangRusak'])->name('barangRusak');
    Route::get('/fetch-no-pmn', [DeviceController::class, 'fetchNoPMN'])->name('fetchNoPMN');
    Route::post('/check-pmn', [PendanaanController::class, 'checkPMN'])->name('checkPMN');
    Route::post('/check-nama', [KategoriController::class, 'checkNama'])->name('checkNama');
    Route::post('/check-nama-sub', [SubKategoriController::class, 'checkNama'])->name('checkNamaSub');
    Route::post('/check-nomor-it', [DeviceController::class, 'checkNomorIT'])->name('checkNomorIT');
    Route::post('/check-nomor-it-dist', [DeviceController::class, 'checkNomorITDist'])->name('checkNomorITDist');
    Route::post('/check-nomor-asset', [AssetController::class, 'checkNomorAsset'])->name('checkNomorAsset');
    Route::post('/check-nomor-asset-dist', [AssetController::class, 'checkNomorAssetDist'])->name('checkNomorAssetDist');
    Route::get('/devices/data', [DeviceController::class, 'fetchDeviceData']);

    Route::get('/edit-foto-device/{device}', [DeviceController::class, 'editFotoDevice']);
    Route::put('/update-foto-device/{device}', [DeviceController::class, 'updateFotoDevice']);

    Route::get('/edit-foto-asset/{asset}', [AssetController::class, 'editFotoAsset']);
    Route::put('/update-foto-asset/{asset}', [AssetController::class, 'updateFotoAsset']);


    Route::resource('/asset', AssetController::class);
    Route::resource('/kategori', KategoriController::class);
    Route::resource('/sub-kategori', SubKategoriController::class);
    Route::resource('/device', DeviceController::class);
    Route::resource('/pendanaan', PendanaanController::class);
    
});


// ================================================================ KARYAWAN ================================================================
Route::group(['middleware' => 'auth:karyawan'], function () {
    Route::get('/karyawan/dashboard', [HomeController::class, 'karyawan'])->name('karyawan.dashboard');
    Route::get('/karyawan/ajukan-kerusakan/{nomor_it}', [DeviceController::class, 'editDeviceKaryawan'])->name('device.ajukan.kerusakan');
    Route::get('/asset/ajukan/kerusakan/{nomor_asset}', [AssetController::class, 'editAssetKaryawan'])->name('asset.ajukan.kerusakan');
    Route::put('/distribusi/update/{id}', [DistributionController::class, 'updateRusak'])->name('updateRusak');
    Route::get('/histroy-device-rusak', [DistributionController::class, 'historyDeviceRusak'])->name('history-device-rusak');
    Route::get('/histroy-asset-rusak', [DistributionController::class, 'historyAssetRusak'])->name('history-asset-rusak');
    Route::get('/karyawan/edit-device/{nomor_it}', [DeviceController::class, 'karyawanEditDev'])->name('karyawan-edit-device');
    Route::put('/karyawan/update-device/{nomor_it}', [DeviceController::class, 'karyawanUpdateDev'])->name('updateDevice');
    Route::post('/update-status/{id}/terima', [HomeController::class, 'updateStatus'])->name('update.status.penerimaan');

});

