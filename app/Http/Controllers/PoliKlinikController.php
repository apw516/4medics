<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\erm_assesmen_dokter;
use App\Models\bridging_ris;
use App\Models\farmasidetailorder;
use App\Models\farmasiheaderorder;
use App\Models\template_resep_detail;
use App\Models\template_resep_header;
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
        $data = DB::connection('mysql2')->select('select counter, fc_nama_px(no_rm) as nama_pasien,no_rm,kode_kunjungan,tgl_masuk,fc_nama_unit1(kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,fc_alamat(no_rm) as alamat from ts_kunjungan where date(tgl_masuk) between ? and ? and kode_unit = ?', [$awal, $akhir, auth()->user()->unit]);
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
        $datalayananobat = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where b.status_layanan_detail = ? and a.kode_unit = ? and a.kode_kunjungan = ?', ['OPN', '4008', $kode_kunjungan]);
        // dd($data);
        return view('Poliklinik.datapemeriksaan', compact([
            'data',
            'dataobat',
            'datalayananobat'
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
        return view('Poliklinik.index_erm', compact([
            'mt_pasien',
            'kunjungan',
            'cekassesmen',
            'rm'
        ]));
    }
    public function ambilRiwayatPemeriksaan(Request $request)
    {
        $rm = $request->rm;
        $assesmen = DB::connection('mysql2')->select('select *,fc_nama_unit1(kode_unit) as nama_unit from erm_assesmen_medis where no_rm = ?', [$rm]);
        $dt2 = DB::connection('mysql2')->select('select * from ts_kunjungan a
        left outer join ts_layanan_header b on a.kode_kunjungan = b.kode_kunjungan
        left outer join ts_layanan_detail c on b.id = c.row_id_header
        where a.no_rm = ? and b.kode_unit = ?',[$rm,'4008']);
        return view('Poliklinik.riwayatpemeriksaan', compact([
            'assesmen','dt2'
        ]));
    }
    public function simpanPemeriksaanDokter(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        $data3 = json_decode($_POST['data2'], true);
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
        $simpanresep = 'TIDAK';
        if($request->simpantemplate == 1){
            if(strlen($request->namaresep) < 5){
                $data = [
                    'kode' => 500,
                    'message' => 'Nama Resep Wajib diisi ... ! minimal 5 karakter '
                ];
                echo json_encode($data);
                die;
            }else{
                $simpanresep = 'YA';
            }
        };
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
            if( $simpanresep == 'YA'){
                $template_header = [
                    'nama_resep' => $request->namaresep,
                    'nama_dokter' => auth()->user()->nama,
                    'pic' => auth()->user()->id,
                    'tgl_entry' => $this->get_date(),
                ];
                $s_t_h = template_resep_header::create($template_header);
            }
            foreach ($array_layanan_obat as $ab) {
                if( $simpanresep == 'YA'){
                    $data_detail_template = [
                        'id_header' => $s_t_h->id,
                        'kode_barang' => $ab['idobat'],
                        'nama_barang' => $ab['namaobat'],
                        'dosis' => $ab['dosis'],
                        'aturan_pakai' => $ab['aturanpakai'],
                        'sediaan' => $ab['sediaan'],
                        'qty' => $ab['qty'],
                        'tgl_entry' => $this->get_now(),
                    ];
                template_resep_detail::create($data_detail_template);
                }
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
    public function ambil_riwayat_obat(request $request)
    {
        $kode_kunjungan = $request->kode_kunjungan;
        $data = db::select('select *,a.id as idheader,b.id as iddetail from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.kode_kunjungan = ?', [$kode_kunjungan]);

        $datalayananobat = db::select('select * from ts_layanan_header a inner join ts_layanan_detail b on a.id = b.row_id_header where b.status_layanan_detail = ? and a.kode_unit = ? and a.kode_kunjungan = ?', ['OPN', '4008', $kode_kunjungan]);

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
    public function ambil_template_resep(request $request)
    {
        $id = auth()->user()->id;
        $data_resep = db::select('select * from farmasi_template_resep_header where pic = ? order by id desc', [$id]);
        $data_resep2 = db::select('select * from farmasi_template_resep_header a inner join farmasi_template_resep_detail b on a.id = b.id_header where a.pic = ?', [$id]);
        return view('Poliklinik.template_resep_dokter', compact([
            'data_resep',
            'data_resep2'
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
    public function ambil_detail_resep_template(Request $request)
    {
        $idresep = $request->id;
        $data_resep2 = db::select('select * from farmasi_template_resep_header a inner join farmasi_template_resep_detail b on a.id = b.id_header where a.id = ?', [$idresep]);
        $str = "";
        foreach($data_resep2 as $d){
            $str .= "<div class='form-row text-xs'><div class='form-group col-md-3'><label for=''>Nama Obat</label><input readonly type='' class='form-control form-control-sm text-xs edit_field' id='' name='namaobat' value='$d->nama_barang'><input hidden readonly type='' class='form-control form-control-sm' id='' name='idobat' value='$d->kode_barang'></div><div class='form-group col-md-1'><label for='inputPassword4'>Sediaan</label><input readonly type='' class='form-control form-control-sm' id='' name='sediaan' value='$d->sediaan'></div><div class='form-group col-md-1'><label for='inputPassword4'>Dosis</label><input readonly type='' class='form-control form-control-sm' id='' name='dosis' value='$d->dosis'></div><div class='form-group col-md-3'><label for='inputPassword4'>Aturan Pakai</label><textarea type='' class='form-control form-control-sm' id='' name='aturanpakai' rows='4'>$d->aturan_pakai</textarea></div><div class='form-group col-md-1'><label for='inputPassword4'>Qty</label><input type='' class='form-control form-control-sm' id='' name='qty' value='$d->qty'></div><i class='bi bi-x-square remove_field form-group col-md-1 text-danger' kode2=''></i></div>";
        }
        return $str;
    }
}
