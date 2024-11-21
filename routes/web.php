<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FarmasiController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PoliKlinikController;
use App\Http\Controllers\RekamedisController;
use App\Http\Controllers\satuSehatController;
use App\Http\Controllers\SatuSehatController as ControllersSatuSehatController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'Index'])->name('/login');
Route::get('/register', [AuthController::class, 'register'])->name('/register');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');
Route::post('register', [AuthController::class, 'post'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/infoakun', [AuthController::class, 'Infoakun'])->middleware('auth')->name('infoakun');


Route::get('/dashboard', [DashboardController::class, 'Index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard2', [DashboardController::class, 'Index_test_satu_Sehat_master_wilayah'])->middleware('auth')->name('dashboard2');


Route::get('/pendaftaran', [RekamedisController::class, 'Index'])->middleware('auth')->name('pendaftaran');
Route::get('/riwayatpendaftaran', [RekamedisController::class, 'riwayatPendaftaran'])->middleware('auth')->name('riwayatpendaftaran');
Route::post('/simpanpasienbaru', [RekamedisController::class, 'simpanPasienBaru'])->middleware('auth')->name('simpanpasienbaru');
Route::post('/simpaneditpasien', [RekamedisController::class, 'simpanEditPasien'])->middleware('auth')->name('simpaneditpasien');
Route::post('/simpanpendaftaran', [RekamedisController::class, 'simpanPendaftaran'])->middleware('auth')->name('simpanpendaftaran');
Route::post('/simpaneditkunjungan', [RekamedisController::class, 'simpanEditKunjungan'])->middleware('auth')->name('simpaneditkunjungan');
Route::post('/caridatapasien', [RekamedisController::class, 'cariDataPasien'])->middleware('auth')->name('cari_data_pasien');
Route::post('/ambilformpendaftaran', [RekamedisController::class, 'ambilFormPendaftaran'])->middleware('auth')->name('ambilformpendaftaran');
Route::post('/ambilformeditpasien', [RekamedisController::class, 'ambilFormEditPasien'])->middleware('auth')->name('ambilformeditpasien');
Route::post('/ambil_detail_kunjungan', [RekamedisController::class, 'ambilDetailKunjungan'])->middleware('auth')->name('ambil_detail_kunjungan');
Route::post('/cari_riwayat_pendaftaran', [RekamedisController::class, 'ambilRiwayatDaftar'])->middleware('auth')->name('cari_riwayat_pendaftaran');
Route::get('/caridesa', [RekamedisController::class, 'cariDesa'])->middleware('auth')->name('caridesa');
Route::get('/cariprovinsi', [RekamedisController::class, 'cariProvinsi'])->middleware('auth')->name('cariprovinsi');
Route::get('/carikabupaten', [RekamedisController::class, 'cariKabupaten'])->middleware('auth')->name('carikabupaten');
Route::get('/carikecamatan', [RekamedisController::class, 'cariKecamatan'])->middleware('auth')->name('carikecamatan');
Route::get('/cariunit', [RekamedisController::class, 'cariUnit'])->middleware('auth')->name('cariunit');
Route::get('/caridokter', [RekamedisController::class, 'cariDokter'])->middleware('auth')->name('caridokter');
Route::post('/hapuspasien', [RekamedisController::class, 'hapusPasien'])->middleware('auth')->name('hapuspasien');

Route::get('/pendaftaran', [RekamedisController::class, 'Index'])->middleware('auth')->name('pendaftaran');
Route::get('/riwayatpendaftaran', [RekamedisController::class, 'riwayatPendaftaran'])->middleware('auth')->name('riwayatpendaftaran');
Route::post('/simpanpasienbaru', [RekamedisController::class, 'simpanPasienBaru'])->middleware('auth')->name('simpanpasienbaru');
Route::post('/simpaneditpasien', [RekamedisController::class, 'simpanEditPasien'])->middleware('auth')->name('simpaneditpasien');
Route::post('/simpanpendaftaran', [RekamedisController::class, 'simpanPendaftaran'])->middleware('auth')->name('simpanpendaftaran');
Route::post('/simpaneditkunjungan', [RekamedisController::class, 'simpanEditKunjungan'])->middleware('auth')->name('simpaneditkunjungan');
Route::post('/caridatapasien', [RekamedisController::class, 'cariDataPasien'])->middleware('auth')->name('cari_data_pasien');
Route::post('/ambilformpendaftaran', [RekamedisController::class, 'ambilFormPendaftaran'])->middleware('auth')->name('ambilformpendaftaran');
Route::post('/ambilformeditpasien', [RekamedisController::class, 'ambilFormEditPasien'])->middleware('auth')->name('ambilformeditpasien');
Route::post('/ambil_detail_kunjungan', [RekamedisController::class, 'ambilDetailKunjungan'])->middleware('auth')->name('ambil_detail_kunjungan');
Route::post('/cari_riwayat_pendaftaran', [RekamedisController::class, 'ambilRiwayatDaftar'])->middleware('auth')->name('cari_riwayat_pendaftaran');
Route::post('/cari_riwayat_pendaftaran_today', [RekamedisController::class, 'ambilRiwayatDaftarToday'])->middleware('auth')->name('cari_riwayat_pendaftaran_today');
Route::get('/caridesa', [RekamedisController::class, 'cariDesa'])->middleware('auth')->name('caridesa');
Route::get('/cariprovinsi', [RekamedisController::class, 'cariProvinsi'])->middleware('auth')->name('cariprovinsi');
Route::get('/carikabupaten', [RekamedisController::class, 'cariKabupaten'])->middleware('auth')->name('carikabupaten');
Route::get('/carikecamatan', [RekamedisController::class, 'cariKecamatan'])->middleware('auth')->name('carikecamatan');
Route::get('/cariunit', [RekamedisController::class, 'cariUnit'])->middleware('auth')->name('cariunit');
Route::get('/caridokter', [RekamedisController::class, 'cariDokter'])->middleware('auth')->name('caridokter');
Route::post('/hapuspasien', [RekamedisController::class, 'hapusPasien'])->middleware('auth')->name('hapuspasien');



//poliklinik
Route::get('/datapasienpoliklinik', [PoliKlinikController::class, 'dataPasienPoliKlinik'])->middleware('auth')->name('datapasienpoliklinik');
Route::get('/riwayatpemeriksaan', [PoliKlinikController::class, 'riwayatPemeriksaan'])->middleware('auth')->name('riwayatpemeriksaan');
Route::post('/cari_riwayat_pasien_poli', [PoliKlinikController::class, 'ambilRiwayatPasienPoli'])->middleware('auth')->name('cari_riwayat_pasien_poli');
Route::post('/cari_riwayat_pasien_poli_by_dokter', [PoliKlinikController::class, 'ambilRiwayatPasienPolibyDokter'])->middleware('auth')->name('cari_riwayat_pasien_poli_by_dokter');
Route::post('/ambil_data_pasien_erm', [PoliKlinikController::class, 'ambilDataPasienErm'])->middleware('auth')->name('ambil_data_pasien_erm');
Route::post('/simpanpemeriksaan', [PoliKlinikController::class, 'simpanPemeriksaanDokter'])->middleware('auth')->name('simpanpemeriksaan');
Route::post('/ambil_riwayat_pemeriksaan', [PoliKlinikController::class, 'ambilRiwayatPemeriksaan'])->middleware('auth')->name('ambil_riwayat_pemeriksaan');
Route::post('/ambil_data_pemeriksaan_pasien', [PoliKlinikController::class, 'ambilDataPemeriksaanPasien'])->middleware('auth')->name('ambil_data_pemeriksaan_pasien');
// Route::get('/testa', [PoliKlinikController::class, 'testapi'])->middleware('auth')->name('test');
Route::get('/datapasienpoliklinik', [PoliKlinikController::class, 'dataPasienPoliKlinik'])->middleware('auth')->name('datapasienpoliklinik');
Route::get('/riwayatpemeriksaan', [PoliKlinikController::class, 'riwayatPemeriksaan'])->middleware('auth')->name('riwayatpemeriksaan');
Route::post('/cari_riwayat_pasien_poli', [PoliKlinikController::class, 'ambilRiwayatPasienPoli'])->middleware('auth')->name('cari_riwayat_pasien_poli');
Route::post('/cari_riwayat_pasien_poli_by_dokter', [PoliKlinikController::class, 'ambilRiwayatPasienPolibyDokter'])->middleware('auth')->name('cari_riwayat_pasien_poli_by_dokter');
Route::post('/ambil_data_pasien_erm', [PoliKlinikController::class, 'ambilDataPasienErm'])->middleware('auth')->name('ambil_data_pasien_erm');
Route::post('/simpanpemeriksaan', [PoliKlinikController::class, 'simpanPemeriksaanDokter'])->middleware('auth')->name('simpanpemeriksaan');
Route::post('/ambil_riwayat_pemeriksaan', [PoliKlinikController::class, 'ambilRiwayatPemeriksaan'])->middleware('auth')->name('ambil_riwayat_pemeriksaan');
Route::post('/ambil_data_pemeriksaan_pasien', [PoliKlinikController::class, 'ambilDataPemeriksaanPasien'])->middleware('auth')->name('ambil_data_pemeriksaan_pasien');
Route::post('/cari_obat_erm', [PoliKlinikController::class, 'cari_obat_erm'])->middleware('auth')->name('cari_obat_erm');
Route::post('/ambil_riwayat_obat', [PoliKlinikController::class, 'ambil_riwayat_obat'])->middleware('auth')->name('ambil_riwayat_obat');
Route::post('/ambil_riwayat_resep', [PoliKlinikController::class, 'ambil_riwayat_resep'])->middleware('auth')->name('ambil_riwayat_resep');
Route::post('/ambil_template_resep', [PoliKlinikController::class, 'ambil_template_resep'])->middleware('auth')->name('ambil_template_resep');
Route::post('/batalorderresep', [PoliKlinikController::class, 'batalOrderResep'])->middleware('auth')->name('batalorderresep');
Route::post('/ambil_detail_resep', [PoliKlinikController::class, 'ambil_detail_resep'])->middleware('auth')->name('ambil_detail_resep');
Route::post('/ambil_detail_resep_template', [PoliKlinikController::class, 'ambil_detail_resep_template'])->middleware('auth')->name('ambil_detail_resep_template');
// Route::get('/testa', [PoliKlinikController::class, 'testapi'])->name('test');

//farmasi
Route::get('/farmasimasterbarang', [FarmasiController::class, 'farmasimasterbarang'])->middleware('auth')->name('farmasimasterbarang');
Route::get('/farmasiorderresep', [FarmasiController::class, 'farmasiorderresep'])->middleware('auth')->name('farmasiorderresep');
Route::get('/riwayatpemberianobat', [FarmasiController::class, 'riwayatpemberianobat'])->middleware('auth')->name('riwayatpemberianobat');
Route::post('/ambilmasterbarang', [FarmasiController::class, 'ambilmasterbarang'])->middleware('auth')->name('ambilmasterbarang');
Route::post('/ambilformmasterbarang', [FarmasiController::class, 'ambilformmasterbarang'])->middleware('auth')->name('ambilformmasterbarang');
Route::post('/simpanmasterbarang', [FarmasiController::class, 'simpanmasterbarang'])->middleware('auth')->name('simpanmasterbarang');
Route::post('/simpanstokbarang', [FarmasiController::class, 'simpanstokbarang'])->middleware('auth')->name('simpanstokbarang');
Route::post('/updatestokbarang', [FarmasiController::class, 'updatestokbarang'])->middleware('auth')->name('updatestokbarang');
Route::post('/ambilformaddstok', [FarmasiController::class, 'ambilformaddstok'])->middleware('auth')->name('ambilformaddstok');
Route::post('/liatstokobat', [FarmasiController::class, 'liatstokobat'])->middleware('auth')->name('liatstokobat');
Route::post('/formeditobat', [FarmasiController::class, 'formeditobat'])->middleware('auth')->name('formeditobat');
Route::post('/cari_order_resep', [FarmasiController::class, 'cari_order_resep'])->middleware('auth')->name('cari_order_resep');
Route::post('/cari_riwayat_pemberian_obat', [FarmasiController::class, 'cari_riwayat_pemberian_obat'])->middleware('auth')->name('cari_riwayat_pemberian_obat');
Route::post('/ambil_detail_orderan', [FarmasiController::class, 'ambilDetailOrderan'])->middleware('auth')->name('ambil_detail_orderan');
Route::post('/ambil_detail_layanan', [FarmasiController::class, 'ambilDetailLayanan'])->middleware('auth')->name('ambil_detail_layanan');
Route::post('/cari_obat_farmasi', [FarmasiController::class, 'cariObatFarmasi'])->middleware('auth')->name('cari_obat_farmasi');
Route::post('/hitungorderanfarmasi', [FarmasiController::class, 'hitungOrderanFarmasi'])->middleware('auth')->name('hitungorderanfarmasi');
Route::post('/simpanorderan', [FarmasiController::class, 'simpanLayananResep'])->middleware('auth')->name('simpanorderan');
Route::post('/batallayananresep', [FarmasiController::class, 'batalLayananResep'])->middleware('auth')->name('batallayananresep');
Route::post('/detail_riwayat_resep', [FarmasiController::class, 'detail_riwayat_resep'])->middleware('auth')->name('detail_riwayat_resep');
Route::get('/cetakresep/{idheader}', [FarmasiController::class, 'cetakresep']); //formpasien_bpjs


//data master
Route::get('/masterpasien', [MasterController::class, 'indexMasterPasien'])->middleware('auth')->name('masterpasien');
Route::get('/masterunit', [MasterController::class, 'indexMasterUnit'])->middleware('auth')->name('masterunit');
Route::get('/masteruser', [MasterController::class, 'indexMasterUser'])->middleware('auth')->name('masteruser');
Route::post('/ambil_master_pasien', [MasterController::class, 'ambilMasterPasien'])->middleware('auth')->name('ambil_master_pasien');
Route::get('/masterpegawai', [MasterController::class, 'indexMasterPegawai'])->middleware('auth')->name('masterpegawai');
Route::post('/ambilmasterunit', [MasterController::class, 'ambilMaterUnit'])->middleware('auth')->name('ambilmasterunit');
Route::post('/ambilmasteruser', [MasterController::class, 'ambilMaterUser'])->middleware('auth')->name('ambilmasteruser');
Route::post('/ambilmasterpergawai', [MasterController::class, 'ambilMaterPegawai'])->middleware('auth')->name('ambilmasterpergawai');
Route::post('/ambilberkaserm', [MasterController::class, 'ambilBerkasErm'])->middleware('auth')->name('ambilberkaserm');
Route::post('/simpanunitbaru', [MasterController::class, 'simpanUnitBaru'])->middleware('auth')->name('simpanunitbaru');
Route::post('/simpanpegawaibaru', [MasterController::class, 'simpanPegawaiBaru'])->middleware('auth')->name('simpanpegawaibaru');
Route::post('/ambil_detail_unit', [MasterController::class, 'ambilDetailUnit'])->middleware('auth')->name('ambil_detail_unit');
Route::post('/ambil_detail_user', [MasterController::class, 'ambilDetailUser'])->middleware('auth')->name('ambil_detail_user');
Route::post('/ambil_detail_pegawai', [MasterController::class, 'ambilDetailPegawai'])->middleware('auth')->name('ambil_detail_pegawai');
Route::post('/simpanupdate', [MasterController::class, 'simpanUpdateUnit'])->middleware('auth')->name('simpanupdate');
Route::post('/simpanupdateuser', [MasterController::class, 'simpanUpdateUser'])->middleware('auth')->name('simpanupdateuser');
Route::post('/simpanupdatepegawai', [MasterController::class, 'simpanUpdatePegawai'])->middleware('auth')->name('simpanupdatepegawai');


//satusehat
Route::get('/indexorganisasilokasi', [SatuSehatController::class, 'indexorganisasilokasi'])->middleware('auth')->name('indexorganisasilokasi');
Route::post('/ambil_form_add_ukp', [SatuSehatController::class, 'ambil_form_add_ukp'])->middleware('auth')->name('ambil_form_add_ukp');
Route::post('/ambil_form_add_koord_poli', [SatuSehatController::class, 'ambil_form_add_koord_poli'])->middleware('auth')->name('ambil_form_add_koord_poli');
Route::post('/ambildatapartner', [SatuSehatController::class, 'ambildatapartner'])->middleware('auth')->name('ambildatapartner');
Route::post('/ambil_loaction_by_orgId', [SatuSehatController::class, 'ambil_loaction_by_orgId'])->middleware('auth')->name('ambil_loaction_by_orgId');
Route::get('/cariprovinsi_satusehat', [satuSehatController::class, 'cariProvinsi'])->middleware('auth')->name('cariprovinsi_satusehat');
Route::get('/carikabupaten_satusehat', [satuSehatController::class, 'cariKabupaten'])->middleware('auth')->name('carikabupaten_satusehat');
Route::get('/carikecamatan_satusehat', [satuSehatController::class, 'cariKecamatan'])->middleware('auth')->name('carikecamatan_satusehat');
Route::get('/caridesa_satusehat', [satuSehatController::class, 'cariDesa'])->middleware('auth')->name('caridesa_satusehat');
Route::get('/carisuborg_satusehat', [satuSehatController::class, 'carisuborg_satusehat'])->middleware('auth')->name('carisuborg_satusehat');
Route::post('/simpanukpbaru', [satuSehatController::class, 'simpanukpbaru'])->middleware('auth')->name('simpanukpbaru');
Route::post('/simpankoordbaru', [satuSehatController::class, 'simpankoordbaru'])->middleware('auth')->name('simpankoordbaru');
