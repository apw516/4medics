<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PoliKlinikController;
use App\Http\Controllers\RekamedisController;
use App\Http\Controllers\SatuSehatController;
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
Route::get('/register', [AuthController::class, 'register'])->name('/register');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('register', [AuthController::class, 'post'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/infoakun', [AuthController::class, 'Infoakun'])->name('infoakun');


Route::get('/dashboard', [DashboardController::class, 'Index'])->name('dashboard');

Route::get('/pendaftaran', [RekamedisController::class, 'Index'])->name('pendaftaran');
Route::get('/riwayatpendaftaran', [RekamedisController::class, 'riwayatPendaftaran'])->name('riwayatpendaftaran');
Route::post('/simpanpasienbaru', [RekamedisController::class, 'simpanPasienBaru'])->name('simpanpasienbaru');
Route::post('/simpaneditpasien', [RekamedisController::class, 'simpanEditPasien'])->name('simpaneditpasien');
Route::post('/simpanpendaftaran', [RekamedisController::class, 'simpanPendaftaran'])->name('simpanpendaftaran');
Route::post('/simpaneditkunjungan', [RekamedisController::class, 'simpanEditKunjungan'])->name('simpaneditkunjungan');
Route::post('/caridatapasien', [RekamedisController::class, 'cariDataPasien'])->name('cari_data_pasien');
Route::post('/ambilformpendaftaran', [RekamedisController::class, 'ambilFormPendaftaran'])->name('ambilformpendaftaran');
Route::post('/ambilformeditpasien', [RekamedisController::class, 'ambilFormEditPasien'])->name('ambilformeditpasien');
Route::post('/ambil_detail_kunjungan', [RekamedisController::class, 'ambilDetailKunjungan'])->name('ambil_detail_kunjungan');
Route::post('/cari_riwayat_pendaftaran', [RekamedisController::class, 'ambilRiwayatDaftar'])->name('cari_riwayat_pendaftaran');
Route::post('/cari_riwayat_pendaftaran_today', [RekamedisController::class, 'ambilRiwayatDaftarToday'])->name('cari_riwayat_pendaftaran_today');
Route::get('/caridesa', [RekamedisController::class, 'cariDesa'])->name('caridesa');
Route::get('/cariprovinsi', [RekamedisController::class, 'cariProvinsi'])->name('cariprovinsi');
Route::get('/carikabupaten', [RekamedisController::class, 'cariKabupaten'])->name('carikabupaten');
Route::get('/carikecamatan', [RekamedisController::class, 'cariKecamatan'])->name('carikecamatan');
Route::get('/cariunit', [RekamedisController::class, 'cariUnit'])->name('cariunit');
Route::get('/caridokter', [RekamedisController::class, 'cariDokter'])->name('caridokter');
Route::get('/caridiagnosa', [RekamedisController::class, 'cariDiagnosa'])->name('caridiagnosa');
Route::post('/hapuspasien', [RekamedisController::class, 'hapusPasien'])->name('hapuspasien');



//poliklinik
Route::get('/datapasienpoliklinik', [PoliKlinikController::class, 'dataPasienPoliKlinik'])->name('datapasienpoliklinik');
Route::get('/riwayatpemeriksaan', [PoliKlinikController::class, 'riwayatPemeriksaan'])->name('riwayatpemeriksaan');
Route::post('/cari_riwayat_pasien_poli', [PoliKlinikController::class, 'ambilRiwayatPasienPoli'])->name('cari_riwayat_pasien_poli');
Route::post('/cari_riwayat_pasien_poli_by_dokter', [PoliKlinikController::class, 'ambilRiwayatPasienPolibyDokter'])->name('cari_riwayat_pasien_poli_by_dokter');
Route::post('/ambil_data_pasien_erm', [PoliKlinikController::class, 'ambilDataPasienErm'])->name('ambil_data_pasien_erm');
Route::post('/simpanpemeriksaan', [PoliKlinikController::class, 'simpanPemeriksaanDokter'])->name('simpanpemeriksaan');
Route::post('/ambil_riwayat_pemeriksaan', [PoliKlinikController::class, 'ambilRiwayatPemeriksaan'])->name('ambil_riwayat_pemeriksaan');
Route::post('/ambil_data_pemeriksaan_pasien', [PoliKlinikController::class, 'ambilDataPemeriksaanPasien'])->name('ambil_data_pemeriksaan_pasien');
Route::post('/cari_obat_erm', [PoliKlinikController::class, 'cari_obat_erm'])->name('cari_obat_erm');
Route::post('/ambil_riwayat_obat', [PoliKlinikController::class, 'ambil_riwayat_obat'])->name('ambil_riwayat_obat');
Route::post('/ambil_riwayat_resep', [PoliKlinikController::class, 'ambil_riwayat_resep'])->name('ambil_riwayat_resep');
Route::post('/ambil_riwayat_tindakan', [PoliKlinikController::class, 'ambil_riwayat_tindakan'])->name('ambil_riwayat_tindakan');
Route::post('/batalorderresep', [PoliKlinikController::class, 'batalOrderResep'])->name('batalorderresep');
Route::post('/bataltindakan', [PoliKlinikController::class, 'batalTindakan'])->name('bataltindakan');
Route::post('/ambil_detail_resep', [PoliKlinikController::class, 'ambil_detail_resep'])->name('ambil_detail_resep');
// Route::get('/testa', [PoliKlinikController::class, 'testapi'])->name('test');


//farmasi
Route::get('/farmasimasterbarang', [FarmasiController::class, 'farmasimasterbarang'])->name('farmasimasterbarang');
Route::get('/farmasiorderresep', [FarmasiController::class, 'farmasiorderresep'])->name('farmasiorderresep');
Route::post('/ambilmasterbarang', [FarmasiController::class, 'ambilmasterbarang'])->name('ambilmasterbarang');
Route::post('/ambilformmasterbarang', [FarmasiController::class, 'ambilformmasterbarang'])->name('ambilformmasterbarang');
Route::post('/simpanmasterbarang', [FarmasiController::class, 'simpanmasterbarang'])->name('simpanmasterbarang');
Route::post('/simpanstokbarang', [FarmasiController::class, 'simpanstokbarang'])->name('simpanstokbarang');
Route::post('/updatestokbarang', [FarmasiController::class, 'updatestokbarang'])->name('updatestokbarang');
Route::post('/ambilformaddstok', [FarmasiController::class, 'ambilformaddstok'])->name('ambilformaddstok');
Route::post('/liatstokobat', [FarmasiController::class, 'liatstokobat'])->name('liatstokobat');
Route::post('/formeditobat', [FarmasiController::class, 'formeditobat'])->name('formeditobat');
Route::post('/cari_order_resep', [FarmasiController::class, 'cari_order_resep'])->name('cari_order_resep');
Route::post('/cari_riwayat_pemakaianobat', [FarmasiController::class, 'cari_riwayat_pemakaianobat'])->name('cari_riwayat_pemakaianobat');
Route::post('/ambil_detail_orderan', [FarmasiController::class, 'ambilDetailOrderan'])->name('ambil_detail_orderan');
Route::post('/ambil_detail_layanan', [FarmasiController::class, 'ambilDetailLayanan'])->name('ambil_detail_layanan');
Route::post('/cari_obat_farmasi', [FarmasiController::class, 'cariObatFarmasi'])->name('cari_obat_farmasi');
Route::post('/hitungorderanfarmasi', [FarmasiController::class, 'hitungOrderanFarmasi'])->name('hitungorderanfarmasi');
Route::post('/simpanorderan', [FarmasiController::class, 'simpanLayananResep'])->name('simpanorderan');
Route::post('/batallayananresep', [FarmasiController::class, 'batalLayananResep'])->name('batallayananresep');
Route::post('/cekorder', [FarmasiController::class, 'cekorder'])->name('cekorder');
Route::get('/farmasiriwayatpemakaianobat', [FarmasiController::class, 'RiwayatPemakaianObat'])->name('farmasiriwayatpemakaianobat');

//kasir
Route::get('/indexdatakasir', [KasirController::class, 'Index'])->name('indexdatakasir');
Route::post('/caridatapasienkasir', [KasirController::class, 'cariDataPasienKasir'])->name('caridatapasienkasir');
Route::post('/ambildeatailtagihan', [KasirController::class, 'detailTagihan'])->name('ambildeatailtagihan');
Route::post('/bayartagihan', [KasirController::class, 'bayarTagihan'])->name('bayartagihan');
Route::post('/detailsudahdibayar', [KasirController::class, 'detailTerbayar'])->name('detailsudahdibayar');
Route::get('/riwayatkasir', [KasirController::class, 'riwayatkasir'])->name('riwayatkasir');
Route::post('/cari_riwayat_kasir', [KasirController::class, 'cari_riwayat_kasir'])->name('cari_riwayat_kasir');


//data master
Route::get('/carikabupaten_byprov', [MasterController::class, 'cariKabupatenByProv'])->name('carikabupaten_byprov');
Route::get('/carikecamatan_bykab', [MasterController::class, 'carikecamatanbykab'])->name('carikecamatan_bykab');
Route::get('/masterlokasi', [MasterController::class, 'indexMasterLokasi'])->name('masterlokasi');
Route::get('/masterpasien', [MasterController::class, 'indexMasterPasien'])->name('masterpasien');
Route::get('/masterunit', [MasterController::class, 'indexMasterUnit'])->name('masterunit');
Route::get('/masteruser', [MasterController::class, 'indexMasterUser'])->name('masteruser');
Route::get('/masterkunjungan', [MasterController::class, 'indexMasterKunjungan'])->name('masterkunjungan');
Route::get('/mastertarif', [MasterController::class, 'indeMasterTarif'])->name('mastertarif');
Route::post('/ambil_master_pasien', [MasterController::class, 'ambilMasterPasien'])->name('ambil_master_pasien');
Route::get('/masterpegawai', [MasterController::class, 'indexMasterPegawai'])->name('masterpegawai');
Route::post('/ambilmasterunit', [MasterController::class, 'ambilMaterUnit'])->name('ambilmasterunit');
Route::post('/ambilmastertarif', [MasterController::class, 'ambilMaterTarif'])->name('ambilmastertarif');
Route::post('/ambilmasteruser', [MasterController::class, 'ambilMaterUser'])->name('ambilmasteruser');
Route::post('/ambilmasterpergawai', [MasterController::class, 'ambilMaterPegawai'])->name('ambilmasterpergawai');
Route::post('/ambilberkaserm', [MasterController::class, 'ambilBerkasErm'])->name('ambilberkaserm');
Route::post('/simpanunitbaru', [MasterController::class, 'simpanUnitBaru'])->name('simpanunitbaru');
Route::post('/simpanpegawaibaru', [MasterController::class, 'simpanPegawaiBaru'])->name('simpanpegawaibaru');
Route::post('/simpantarifbaru', [MasterController::class, 'simpanTarifBaru'])->name('simpantarifbaru');
Route::post('/ambil_detail_unit', [MasterController::class, 'ambilDetailUnit'])->name('ambil_detail_unit');
Route::post('/ambil_detail_user', [MasterController::class, 'ambilDetailUser'])->name('ambil_detail_user');
Route::post('/ambil_detail_pegawai', [MasterController::class, 'ambilDetailPegawai'])->name('ambil_detail_pegawai');
Route::post('/ambil_detail_tarif', [MasterController::class, 'ambilDetailTarif'])->name('ambil_detail_tarif');
Route::post('/simpanupdate', [MasterController::class, 'simpanUpdateUnit'])->name('simpanupdate');
Route::post('/simpanupdatetarif', [MasterController::class, 'simpanUpdateTarif'])->name('simpanupdatetarif');
Route::post('/simpanupdateuser', [MasterController::class, 'simpanUpdateUser'])->name('simpanupdateuser');
Route::post('/simpanupdatepegawai', [MasterController::class, 'simpanUpdatePegawai'])->name('simpanupdatepegawai');
Route::post('/kirimdatapasiensatusehat', [MasterController::class, 'kirimPasienSatuSehat'])->name('kirimdatapasiensatusehat');
Route::post('/cari_kunjungan_pasien', [MasterController::class, 'ambilDataKunjunganIHS'])->name('cari_kunjungan_pasien');
Route::post('/kirimdatakunjungansatusehat', [MasterController::class, 'kirimKunjunganSatuSehat'])->name('kirimdatakunjungansatusehat');
Route::post('/kirimdataunitsatusehat', [MasterController::class, 'kirimdataunitsatusehat'])->name('kirimdataunitsatusehat');
Route::post('/caripasienihs', [MasterController::class, 'cariPasienSatusehat'])->name('caripasienihs');
Route::post('/editpasienihs', [MasterController::class, 'editPasienIHS'])->name('editpasienihs');
Route::post('/getmasterdesa', [MasterController::class, 'getmasterdesa'])->name('getmasterdesa');
Route::post('/getmasterkecamatan', [MasterController::class, 'getmasterkecamatan'])->name('getmasterkecamatan');
Route::post('/getmasterkab', [MasterController::class, 'getmasterkab'])->name('getmasterkab');

