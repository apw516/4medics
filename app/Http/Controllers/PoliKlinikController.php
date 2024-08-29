<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\erm_assesmen_dokter;
use App\Models\bridging_ris;
use App\Models\TS_kunjungan;

class PoliKlinikController extends Controller
{
    public function dataPasienPoliKlinik()
    {
        $menu = 'datapasien_erm';
        $date = $this->get_date();
        return view('Poliklinik.datapasienpoli', compact([
            'menu', 'date'
        ]));
    }
    public function riwayatPemeriksaan()
    {
        $menu = 'riwayatpemeriksaan';
        $date = $this->get_date();
        return view('Poliklinik.datariwayatpemeriksaan', compact([
            'menu', 'date'
        ]));
    }
    public function ambilRiwayatPasienPoli(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = DB::connection('mysql2')->select('select counter, fc_nama_px(no_rm) as nama_pasien,no_rm,kode_kunjungan,tgl_masuk,fc_nama_unit1(kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,fc_alamat(no_rm) as alamat from ts_kunjungan where date(tgl_masuk) between ? and ? and kode_unit = ?', [$awal, $akhir,auth()->user()->unit]);
        return view('Poliklinik.tabel_pasien_poli', compact([
            'data'
        ]));
    }
    public function ambilRiwayatPasienPolibyDokter(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = DB::connection('mysql2')->select('select counter, fc_nama_px(no_rm) as nama_pasien,no_rm,kode_kunjungan,tgl_masuk,fc_nama_unit1(kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,fc_alamat(no_rm) as alamat from ts_kunjungan where date(tgl_masuk) between ? and ? and kode_paramedis = ?', [$awal, $akhir,auth()->user()->kode_paramedis]);
        return view('Poliklinik.tabel_pasien_poli_dokter', compact([
            'data'
        ]));
    }
    public function ambilDataPemeriksaanPasien(Request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $data = DB::connection('mysql2')->select('select * from erm_assesmen_medis where kodekunjungan = ?',[$kode_kunjungan]);
        // dd($data);
        return view('Poliklinik.datapemeriksaan',compact([
            'data'
        ]));
    }
    public function ambilDataPasienErm(Request $request)
    {
        $kodekunjungan = $request->kode_kunjungan;
        $kunjungan = DB::connection('mysql2')->select('select * from ts_kunjungan where kode_kunjungan = ?', [$kodekunjungan]);
        $mt_pasien = DB::connection('mysql2')->select('select *,fc_alamat(no_rm) as alamat2,date(tgl_lahir) as tgl_lahir2 from mt_pasien where no_rm = ?', [$kunjungan[0]->no_rm]);
        $rm = $mt_pasien[0]->no_rm;
        $cekassesmen = DB::connection('mysql2')->select('select * from erm_assesmen_medis where no_rm = ? and id = (select max(id) as id from erm_assesmen_medis where no_rm = ?)', [$rm,$rm]);
        return view('Poliklinik.index_erm', compact([
            'mt_pasien', 'kunjungan','cekassesmen','rm'
        ]));
    }
    public function ambilRiwayatPemeriksaan(Request $request)
    {
        $rm = $request->rm;
        $assesmen = DB::connection('mysql2')->select('select *,fc_nama_unit1(kode_unit) as nama_unit from erm_assesmen_medis where no_rm = ?',[$rm]);
        return view('Poliklinik.riwayatpemeriksaan',compact([
            'assesmen'
        ]));
    }
    public function simpanPemeriksaanDokter(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }

        $data_pemeriksaan = [
            'counter' => $dataSet['counter'],
            'kodekunjungan' => $dataSet['kodekunjungan'],
            'no_rm' => $dataSet['norm'],
            'kode_unit' => $dataSet['kode_unit'],
            'tgl_masuk' => $dataSet['tglmasuk'],
            'tgl_periksa' => $dataSet['tglmasuk'],
            'tgl_entry' => $dataSet['tglmasuk'],
            'tekanan_darah' => $dataSet['tekanandarah'],
            'suhu_tubuh' => $dataSet['suhutubuh'],
            'subject' => $dataSet['subject'],
            'object' => $dataSet['object'],
            'assesment' => $dataSet['assesment'],
            'planning' => $dataSet['planning'],
            'kode_paramedis' => auth()->user()->kode_paramedis,
            'pic' => auth()->user()->id,
            'nama_dokter' => auth()->user()->nama,
        ];
        $cek = DB::connection('mysql2')->select('select * from erm_assesmen_medis where kodekunjungan = ?', [$dataSet['kodekunjungan']]);
        if (count($cek) > 0) {
            erm_assesmen_dokter::whereRaw('kodekunjungan = ?', array($dataSet['kodekunjungan']))->update($data_pemeriksaan);
        } else {
            erm_assesmen_dokter::create($data_pemeriksaan);
        }
        TS_kunjungan::whereRaw('kode_kunjungan = ?', array($dataSet['kodekunjungan']))->update(['kode_paramedis' => auth()->user()->kode_paramedis]);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function get_time()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        return $time;
    }
    public function get_now()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $now = $date . ' ' . $time;
        return $now;
    }
    public function get_date()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $now = $date;
        return $now;
    }
    public function testapi()
    {
        $v = new bridging_ris();
        $p = $v->saveorder();
        dd($p);
    }
}
