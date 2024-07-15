<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PoliKlinikController;
use App\Http\Controllers\RekamedisController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'Index'])->name('/login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/infoakun', [AuthController::class, 'Infoakun'])->name('infoakun');


Route::get('/dashboard', [DashboardController::class, 'Index'])->name('dashboard');

Route::get('/pendaftaran', [RekamedisController::class, 'Index'])->name('pendaftaran');
Route::get('/riwayatpendaftaran', [RekamedisController::class, 'riwayatPendaftaran'])->name('riwayatpendaftaran');
Route::post('/simpanpasienbaru', [RekamedisController::class, 'simpanPasienBaru'])->name('simpanpasienbaru');
Route::post('/simpanpendaftaran', [RekamedisController::class, 'simpanPendaftaran'])->name('simpanpendaftaran');
Route::post('/simpaneditkunjungan', [RekamedisController::class, 'simpanEditKunjungan'])->name('simpaneditkunjungan');
Route::post('/caridatapasien', [RekamedisController::class, 'cariDataPasien'])->name('cari_data_pasien');
Route::post('/ambilformpendaftaran', [RekamedisController::class, 'ambilFormPendaftaran'])->name('ambilformpendaftaran');
Route::post('/ambil_detail_kunjungan', [RekamedisController::class, 'ambilDetailKunjungan'])->name('ambil_detail_kunjungan');
Route::post('/cari_riwayat_pendaftaran', [RekamedisController::class, 'ambilRiwayatDaftar'])->name('cari_riwayat_pendaftaran');
Route::get('/caridesa', [RekamedisController::class, 'cariDesa'])->name('caridesa');
Route::get('/cariunit', [RekamedisController::class, 'cariUnit'])->name('cariunit');
Route::get('/caridokter', [RekamedisController::class, 'cariDokter'])->name('caridokter');





//poliklinik
Route::get('/datapasienpoliklinik', [PoliKlinikController::class, 'dataPasienPoliKlinik'])->name('datapasienpoliklinik');
Route::get('/riwayatpemeriksaan', [PoliKlinikController::class, 'riwayatPemeriksaan'])->name('riwayatpemeriksaan');
Route::post('/cari_riwayat_pasien_poli', [PoliKlinikController::class, 'ambilRiwayatPasienPoli'])->name('cari_riwayat_pasien_poli');
Route::post('/cari_riwayat_pasien_poli_by_dokter', [PoliKlinikController::class, 'ambilRiwayatPasienPolibyDokter'])->name('cari_riwayat_pasien_poli_by_dokter');
Route::post('/ambil_data_pasien_erm', [PoliKlinikController::class, 'ambilDataPasienErm'])->name('ambil_data_pasien_erm');
Route::post('/simpanpemeriksaan', [PoliKlinikController::class, 'simpanPemeriksaanDokter'])->name('simpanpemeriksaan');
Route::post('/ambil_riwayat_pemeriksaan', [PoliKlinikController::class, 'ambilRiwayatPemeriksaan'])->name('ambil_riwayat_pemeriksaan');
Route::post('/ambil_data_pemeriksaan_pasien', [PoliKlinikController::class, 'ambilDataPemeriksaanPasien'])->name('ambil_data_pemeriksaan_pasien');
// Route::get('/testa', [PoliKlinikController::class, 'testapi'])->name('test');
