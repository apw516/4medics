<?php

namespace App\Http\Controllers;

use App\Models\layanan_detail;
use App\Models\layanan_header;
use App\Models\TS_kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends FarmasiController
{
    public function Index()
    {
        $menu = 'datapasienkasir';
        $date = $this->get_date();
        return view('Kasir.indexdatapasien', compact([
            'menu',
            'date'
        ]));
    }
    public function cariDataPasienKasir(Request $request){
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = DB::connection('mysql2')->select('select a.status_kunjungan, b.id as idassesmen, a.counter, fc_nama_px(a.no_rm) as nama_pasien,a.no_rm,kode_kunjungan,a.tgl_masuk,fc_nama_unit1(a.kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(a.kode_paramedis) as nama_dokter,fc_alamat(a.no_rm) as alamat from ts_kunjungan a left outer join erm_assesmen_medis b on a.kode_kunjungan = b.kodekunjungan where date(a.tgl_masuk) between ? and ? and a.kode_unit = ? and a.status_kunjungan != ?', [$awal, $akhir, auth()->user()->unit,8]);
        return view('Kasir.tabeldatapasien',compact([
            'data'
        ]));
    }
    public function detailTagihan(Request $request){
        $kode_kunjungan = $request->kode_kunjungan;
        $data = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where a.kode_kunjungan = ? and a.status_layanan = ? and status_layanan_detail = ?',[$request->kode_kunjungan,1,'OPN']);
        return view('Kasir.detail_tagihan',compact([
            'data','kode_kunjungan'
        ]));
    }
    public function riwayatkasir()
    {
        $menu = 'Riwayat Transaksi Kasir';
        $date = $this->get_date();
        return view('Kasir.indexriwayatkasir', compact([
            'menu','date'
        ]));
    }
    public function cari_riwayat_kasir(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data  = db::select('select *,a.tgl_entry as tgl_layanan,fc_alamat(c.no_rm) as alamat_pasien from ts_layanan_header a inner join ts_kunjungan b on a.kode_kunjungan = b.kode_kunjungan inner join mt_pasien c on b.no_rm = c.no_rm inner join ts_layanan_detail d on a.id = d.row_id_header where date(a.tgl_entry) between ? and ? and a.status_layanan != ?', [$awal, $akhir, 3]);
        return view('Kasir.tabel_riwayat_kasir', compact([
            'data','awal','akhir'
        ]));
    }
    public function detailTerbayar(Request $request){
        $kode_kunjungan = $request->kode_kunjungan;
        $data = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where a.kode_kunjungan = ? and a.status_layanan = ? and status_layanan_detail = ?',[$request->kode_kunjungan,2,'CLS']);
        return view('Kasir.detail_tagihan_terbayar',compact([
            'data','kode_kunjungan'
        ]));
    }
    public function bayarTagihan(Request $request)
    {
        $kodekunjungan = $request->kodekunjungan;
        $dataheader = db::select('select * from ts_layanan_header where kode_kunjungan = ? and status_layanan = ?',[$kodekunjungan,1]);
        foreach($dataheader as $dh){
            $detail = db::select('select * from ts_layanan_detail where row_id_header = ? and status_layanan_detail = ?',[$dh->id,'OPN']);
            foreach($detail as $d){
                layanan_detail::whereRaw('id = ?', array($d->id))->update(['status_layanan_detail' => 'CLS']);
            }
            layanan_header::whereRaw('id = ?', array($dh->id))->update(['status_layanan' => '2']);
        }
        TS_kunjungan::whereRaw('kode_kunjungan = ?', array($kodekunjungan))->update(['status_kunjungan' => '2']);

        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
}
