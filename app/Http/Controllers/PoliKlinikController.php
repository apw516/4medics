<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\erm_assesmen_dokter;
use App\Models\bridging_ris;
use App\Models\farmasidetailorder;
use App\Models\farmasiheaderorder;
use App\Models\ihs_ts_kunjungan;
use App\Models\layanan_detail;
use App\Models\layanan_header;
use App\Models\TS_kunjungan;

class PoliKlinikController extends Controller
{
    public function dataPasienPoliKlinik()
    {
        $menu = 'datapasien_erm';
        $date = $this->get_date();
        return view('Poliklinik.datapasienpoli', compact([
            'menu',
            'date'
        ]));
    }
    public function riwayatPemeriksaan()
    {
        $menu = 'riwayatpemeriksaan';
        $date = $this->get_date();
        return view('Poliklinik.datariwayatpemeriksaan', compact([
            'menu',
            'date'
        ]));
    }
    public function ambilRiwayatPasienPoli(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = DB::connection('mysql2')->select('select b.id as idassesmen, a.counter, fc_nama_px(a.no_rm) as nama_pasien,a.no_rm,kode_kunjungan,a.tgl_masuk,fc_nama_unit1(a.kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(a.kode_paramedis) as nama_dokter,fc_alamat(a.no_rm) as alamat from ts_kunjungan a left outer join erm_assesmen_medis b on a.kode_kunjungan = b.kodekunjungan where date(a.tgl_masuk) between ? and ? and a.kode_unit = ?', [$awal, $akhir, auth()->user()->unit]);
        return view('Poliklinik.tabel_pasien_poli', compact([
            'data'
        ]));
    }
    public function ambilRiwayatPasienPolibyDokter(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = DB::connection('mysql2')->select('select counter, fc_nama_px(no_rm) as nama_pasien,no_rm,kode_kunjungan,tgl_masuk,fc_nama_unit1(kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,fc_alamat(no_rm) as alamat from ts_kunjungan where date(tgl_masuk) between ? and ? and kode_paramedis = ?', [$awal, $akhir, auth()->user()->kode_paramedis]);
        return view('Poliklinik.tabel_pasien_poli_dokter', compact([
            'data'
        ]));
    }
    public function ambilDataPemeriksaanPasien(Request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $data = DB::connection('mysql2')->select('select * from erm_assesmen_medis where kodekunjungan = ?', [$kode_kunjungan]);
        $dataobat = db::select('select * from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.kode_kunjungan = ?', [$kode_kunjungan]);

        $datalayananobat = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where b.status_layanan_detail != ? and a.kode_unit = ? and a.kode_kunjungan = ?', ['CCL', '4008', $kode_kunjungan]);

        $TINDAKAN = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where b.status_layanan_detail != ? and a.kode_unit != ? and a.kode_kunjungan = ?', ['CCL', '4008', $kode_kunjungan]);
        // dd($data);
        return view('Poliklinik.datapemeriksaan', compact([
            'data',
            'dataobat',
            'datalayananobat','TINDAKAN'
        ]));
    }
    public function cari_obat_erm(Request $request)
    {
        $nama = $request->namaobat;
        if (strlen($nama) < 3) {
            $master_barang = db::select('select * from mt_barang where nama_barang LIKE ? ORDER BY id DESC LIMIT 200', ['%' . $nama . '%']);
        } else {
            $master_barang = db::select('select * from mt_barang where nama_barang LIKE ?', ['%' . $nama . '%']);
        }
        return view('Poliklinik.tabelobaterm', compact([
            'master_barang'
        ]));
    }
    public function ambilDataPasienErm(Request $request)
    {
        $kodekunjungan = $request->kode_kunjungan;
        $kunjungan = DB::connection('mysql2')->select('select * from ts_kunjungan where kode_kunjungan = ?', [$kodekunjungan]);
        $mt_pasien = DB::connection('mysql2')->select('select *,fc_alamat(no_rm) as alamat2,date(tgl_lahir) as tgl_lahir2 from mt_pasien where no_rm = ?', [$kunjungan[0]->no_rm]);
        $rm = $mt_pasien[0]->no_rm;
        $cekassesmen = DB::connection('mysql2')->select('select * from erm_assesmen_medis where no_rm = ? and id = (select max(id) as id from erm_assesmen_medis where no_rm = ?)', [$rm, $rm]);
        $cekdiagnosa = DB::connection('mysql2')->select('select * from ihs_ts_kunjungan where no_rm = ? and id = (select max(id) as id from ihs_ts_kunjungan where no_rm = ?)', [$rm, $rm]);
        $cekihskunjungan = db::select('select * from ihs_ts_kunjungan where kode_kunjungan = ?',[$kodekunjungan]);
        if($cekihskunjungan[0]->status_antrian == 0){
            $dataihskunjungan = [
                'status_antrian' => 1,
                'jam_panggil' => $this->get_time(),
            ];
            ihs_ts_kunjungan::whereRaw('kode_kunjungan = ?', array($kodekunjungan))->update($dataihskunjungan);
        }
        $mt_tarif = db::select('select *,a.id as idtarif from mt_tarif_baru a left outer join mt_unit b on a.kode_unit = b.kode_unit where a.status = 1');
        return view('Poliklinik.index_erm', compact([
            'mt_pasien',
            'kunjungan',
            'cekassesmen',
            'rm','cekdiagnosa',
            'mt_tarif'
        ]));
    }
    public function ambilRiwayatPemeriksaan(Request $request)
    {
        $rm = $request->rm;
        $assesmen = DB::connection('mysql2')->select('select *,fc_nama_unit1(kode_unit) as nama_unit from erm_assesmen_medis where no_rm = ? order by counter desc', [$rm]);
        $dt2 = DB::connection('mysql2')->select('select * from ts_kunjungan a
        left outer join ts_layanan_header b on a.kode_kunjungan = b.kode_kunjungan
        left outer join ts_layanan_detail c on b.id = c.row_id_header
        where a.no_rm = ? and b.kode_unit = ? and c.status_layanan_detail = ?',[$rm,'4008','CLS']);
        $dt3 = DB::connection('mysql2')->select('select * from ts_kunjungan a
        left outer join ts_layanan_header b on a.kode_kunjungan = b.kode_kunjungan
        left outer join ts_layanan_detail c on b.id = c.row_id_header
        where a.no_rm = ? and b.kode_unit != ? and c.status_layanan_detail = ?',[$rm,'4008','CLS']);
        return view('Poliklinik.riwayatpemeriksaan', compact([
            'assesmen','dt2','dt3'
        ]));
    }
    public function createLayananheader($unit)
    {
        $q = DB::connection('mysql2')->select('SELECT id,kode_layanan_header,RIGHT(kode_layanan_header,6) AS kd_max  FROM ts_layanan_header
        WHERE DATE(tgl_entry) = CURDATE() AND kode_unit = ?
        ORDER BY id DESC
        LIMIT 1',[$unit]);
        $mt_unit = db::select('select * from mt_unit where kode_unit = ?',[$unit]);
        $pref = $mt_unit[0]->prefix_unit;
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return $pref . date('ymd') . $kd;
    }
    public function createLayanandetail()
    {
        $q = DB::connection('mysql2')->select('SELECT id,id_layanan_detail,RIGHT(id_layanan_detail,6) AS kd_max  FROM ts_layanan_detail
        WHERE DATE(tgl_layanan_detail) = CURDATE()
        ORDER BY id DESC
        LIMIT 1');
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'DET' . date('ymd') . $kd;
    }
    public function simpanPemeriksaanDokter(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        $data3 = json_decode($_POST['data2'], true);
        $data4 = json_decode($_POST['data4'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'qty') {
                $array_layanan_obat[] = $dataSet3;
            }
        }

        // if(strlen())
        if(strlen($dataSet['subject']) < 5){
            $data = [
                'kode' => 500,
                'message' => 'Subject harus diisi !'
            ];
            echo json_encode($data);
            die;
        }
        if(strlen($dataSet['planning']) < 5){
            $data = [
                'kode' => 500,
                'message' => 'Planning harus diisi !'
            ];
            echo json_encode($data);
            die;
        }
        if(strlen($dataSet['kodediagnosaprimer']) < 1){
            $data = [
                'kode' => 500,
                'message' => 'pilih diagnosa yang tersedia didropdown !'
            ];
            echo json_encode($data);
            die;
        }
        if(strlen($dataSet['displaydiagnosaprimer']) < 1){
            $data = [
                'kode' => 500,
                'message' => 'pilih diagnosa yang tersedia didropdown !'
            ];
            echo json_encode($data);
            die;
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
            'frekuensi_nafas' => $dataSet['frekuensinafas'],
            'tinggi_badan' => $dataSet['tinggibadan'],
            'berat_badan' => $dataSet['beratbadan'],
            'usia_pasien' => $dataSet['usia'],
            'subject' => $dataSet['subject'],
            'object' => $dataSet['object'],
            'assesment' => $dataSet['assesment'],
            'planning' => $dataSet['planning'],
            'kode_paramedis' => auth()->user()->kode_paramedis,
            'pic' => auth()->user()->id,
            'nama_dokter' => auth()->user()->nama,
            'diagnosa_primer' => $dataSet['kodediagnosaprimer'],
            'display_diagnosa_primer' => $dataSet['displaydiagnosaprimer'],
        ];
        $cek = DB::connection('mysql2')->select('select * from erm_assesmen_medis where kodekunjungan = ?', [$dataSet['kodekunjungan']]);
        if (count($cek) > 0) {
            erm_assesmen_dokter::whereRaw('kodekunjungan = ?', array($dataSet['kodekunjungan']))->update($data_pemeriksaan);
        } else {
            erm_assesmen_dokter::create($data_pemeriksaan);
        }
        if(count($data4) > 0){
            foreach ($data4 as $nama4) {
                $index4 = $nama4['name'];
                $value4 = $nama4['value'];
                $dataSet4[$index4] = $value4;
                if ($index4 == 'qty') {
                    $arraytindakan[] = $dataSet4;
                }
            }
            $kode_layanan_header =  $this->createLayananheader(auth()->user()->unit);
            $ts_kunjungan = db::select('select * from ts_kunjungan where kode_kunjungan = ?',[$dataSet['kodekunjungan']]);
            $datalayananheader = $data_layanan_header = [
                'kode_layanan_header' => $kode_layanan_header,
                'tgl_entry' => $this->get_now(),
                'kode_kunjungan' => $dataSet['kodekunjungan'],
                'kode_unit' => auth()->user()->unit,
                'kode_tipe_transaksi' => '1',
                'pic' => auth()->user()->id,
                'status_layanan' => 1,
                'dok_kirim' =>auth()->user()->kode_paramedis,
                'kode_unit' => $ts_kunjungan[0]->kode_unit,
            ];
            $layanan_header = layanan_header::create($data_layanan_header);
            $gt_header = 0;
            foreach ($arraytindakan as $at) {
                $id_detail = $this->createLayanandetail();
                $data_detail = [
                    'id_layanan_detail' =>$id_detail,
                    'kode_layanan_header' => $kode_layanan_header,
                    'kode_tarif_detail' => $at['idtarif'],
                    'total_tarif' => $at['tarif'],
                    'jumlah_layanan' => $at['qty'],
                    'total_layanan' => $at['qty'] * $at['tarif'],
                    'grantotal_layanan' => $at['qty'] * $at['tarif'],
                    'tgl_layanan_detail' => $this->get_now(),
                    'status_layanan_detail' => 'OPN',
                    'tagihan_pribadi' => $at['qty'] * $at['tarif'],
                    'row_id_header' => $layanan_header->id,
                    'keterangan01' => $at['namatarif'],
                ];
                layanan_detail::create($data_detail);
                $gt = $at['qty'] * $at['tarif'];
                $gt_header = $gt_header + $gt;
            }
            layanan_header::whereRaw('id = ?', $layanan_header->id)->update(['total_layanan' => $gt_header, 'tagihan_pribadi' => $gt_header]);
        }
        $kodekunjungan = $dataSet['kodekunjungan'];
        TS_kunjungan::whereRaw('kode_kunjungan = ?', array($dataSet['kodekunjungan']))->update(['kode_paramedis' => auth()->user()->kode_paramedis]);
        $dataSet['displaydiagnosaprimer'];
        $dataSet['kodediagnosaprimer'];
        $dataSet['displaydiagnosasekunder'];
        $dataSet['kodediagnosasekunder'];
        $ihs_kunjungan = [
            'jam_selesai' => $this->get_time(),
            'keluhan_pasien' =>  $dataSet['subject'],
            'kode_ihs_dokter' => auth()->user()->ihs_code,
            'nama_dokter' => auth()->user()->nama,
            'diagnosa_primer' =>$dataSet['kodediagnosaprimer'],
            'display_diagnosa_primer' => $dataSet['displaydiagnosaprimer'],
            'diagnosa_sekunder' =>$dataSet['kodediagnosasekunder'],
            'display_diagnosa_sekunder' => $dataSet['displaydiagnosasekunder'],
            'status_pemeriksaan' => 2,
            'planning' => $dataSet['planning'],
        ];
        ihs_ts_kunjungan::whereRaw('kode_kunjungan = ?', array($kodekunjungan))->update($ihs_kunjungan);
        //farmasi
        if (count($data3) > 0) {
            $mt_pasien = db::select('select * from mt_pasien where no_rm = ?', [$dataSet['norm']]);
            $mt_unit = db::select('select * from mt_unit where kode_unit = ?', [auth()->user()->unit]);
            $data_header = [
                'kode_kunjungan' => $dataSet['kodekunjungan'],
                'no_rm' => $dataSet['norm'],
                'nama_pasien' => $mt_pasien[0]->nama_px,
                'dok_kirim' => auth()->user()->id,
                'nama_dokter' => auth()->user()->nama,
                'tgl_entry' => $this->get_now(),
                'unit_kirim' => auth()->user()->unit,
                'nama_unit_kirim' => $mt_unit[0]->nama_unit,
                'status' => '1',
            ];
            // dd($array_layanan_obat);
            $header_order = farmasiheaderorder::create($data_header);
            foreach ($array_layanan_obat as $ab) {
                $data_detail = [
                    'id_header' => $header_order->id,
                    'kode_barang' => $ab['idobat'],
                    'nama_barang' => $ab['namaobat'],
                    'dosis' => $ab['dosis'],
                    'aturan_pakai' => $ab['aturanpakai'],
                    'sediaan' => $ab['sediaan'],
                    'qty' => $ab['qty'],
                    'tgl_entry' => $this->get_now(),
                    'status' => 1
                ];
                farmasidetailorder::create($data_detail);
            }
        }
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
    public function batalOrderResep(Request $request)
    {
        $id = $request->iddetail;
        $deleted = DB::table('farmasi_detail_order')->where('id', '=', $id)->delete();
        $cek = db::select('select * from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.id =?', [$request->idheader]);
        // dd(count($cek));
        if (count($cek) == 0) {
            $a = DB::table('farmasi_header_order')->where('id', '=', $request->idheader)->delete();
        };
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function batalTindakan(Request $request)
    {
        $iddetail = $request->iddetail;
        $idheader = $request->idheader;
        $detail = db::select('select * from ts_layanan_detail where id = ?',[$iddetail]);
        if($detail[0]->status_layanan_detail == 'CCL'){
            $data = [
                'kode' => 500,
                'message' => 'Gagal, Layanan sudah diretur sebelumnya'
            ];
            echo json_encode($data);
            die;
        }
        $detail_new = [
            'jumlah_retur' => $detail[0]->jumlah_layanan,
            'status_layanan_detail' => 'CCL',
            'grantotal_layanan' => 0,
            'tagihan_pribadi' => 0,
        ];
        layanan_detail::whereRaw('id = ?', $iddetail)->update($detail_new);
        $header = db::select('select * from ts_layanan_header where id = ?',[$idheader]);
        $detail2 = db::select('select * from ts_layanan_detail where row_id_header = ? and status_layanan_detail = ?',[$idheader,'OPN']);
        $total_layanan_header = $header[0]->total_layanan;
        $new_total_layanan_header = $total_layanan_header - $detail[0]->grantotal_layanan;
        if($new_total_layanan_header < 0){
            $new_total_layanan_header = 0;
        }
        if(count($detail2) > 0){
            $status_header = 1;
            $status_retur = 'OPN';
        }else{
            $status_header = 3;
            $status_retur = 'CLS';
        }
        $data_header = [
            'status_layanan' => $status_header,
            'status_retur' => $status_retur,
            'total_layanan' => $new_total_layanan_header,
            'tagihan_pribadi' => $new_total_layanan_header
        ];
        layanan_header::whereRaw('id = ?',$idheader)->update($data_header);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function ambil_riwayat_obat(request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $data = db::select('select *,a.id as idheader,b.id as iddetail from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.kode_kunjungan = ?', [$kode_kunjungan]);
        $datalayananobat = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where b.status_layanan_detail != ? and a.kode_unit = ? and a.kode_kunjungan = ?', ['CCL', '4008', $kode_kunjungan]);

        return view('Poliklinik.riwayat_obat_terkirim', compact([
            'data',
            'datalayananobat'
        ]));
    }
    public function ambil_riwayat_resep(request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $data_kunjungan = db::select('select * from ts_kunjungan where kode_kunjungan = ?', [$kode_kunjungan]);
        $rm = $data_kunjungan[0]->no_rm;
        $data_resep = db::select('select * from farmasi_header_order where no_rm = ? order by id desc', [$rm]);
        $data_resep2 = db::select('select * from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.no_rm = ?', [$rm]);
        return view('Poliklinik.riwayat_resep', compact([
            'data_resep',
            'data_resep2'
        ]));
    }
    public function ambil_riwayat_tindakan(request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $riwayat = db::select('select *,a.id as idheader ,b.id as iddetail from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where kode_kunjungan = ? and kode_tarif_detail != ? and b.status_layanan_detail != ?',[$kode_kunjungan,'NULL','CCL']);
        return view('Poliklinik.riwayat_tindakan', compact([
            'riwayat'
        ]));
    }
    public function testapi()
    {
        $v = new bridging_ris();
        $p = $v->saveorder();
        dd($p);
    }
    public function ambil_detail_resep(Request $request)
    {
        $idresep = $request->id;
        $data_resep2 = db::select('select * from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.id = ?', [$idresep]);
        $str = "";
        foreach($data_resep2 as $d){
            $str .= "<div class='form-row text-xs'><div class='form-group col-md-3'><label for=''>Nama Obat</label><input readonly type='' class='form-control form-control-sm text-xs edit_field' id='' name='namaobat' value='$d->nama_barang'><input hidden readonly type='' class='form-control form-control-sm' id='' name='idobat' value='$d->kode_barang'></div><div class='form-group col-md-1'><label for='inputPassword4'>Sediaan</label><input readonly type='' class='form-control form-control-sm' id='' name='sediaan' value='$d->sediaan'></div><div class='form-group col-md-1'><label for='inputPassword4'>Dosis</label><input readonly type='' class='form-control form-control-sm' id='' name='dosis' value='$d->dosis'></div><div class='form-group col-md-3'><label for='inputPassword4'>Aturan Pakai</label><textarea type='' class='form-control form-control-sm' id='' name='aturanpakai' rows='4'>$d->aturan_pakai</textarea></div><div class='form-group col-md-1'><label for='inputPassword4'>Qty</label><input type='' class='form-control form-control-sm' id='' name='qty' value='$d->qty'></div><i class='bi bi-x-square remove_field form-group col-md-1 text-danger' kode2=''></i></div>";
        }
        return $str;
    }
}
