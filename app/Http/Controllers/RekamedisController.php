<?php

namespace App\Http\Controllers;

use App\Models\Mt_pasien;
use App\Models\TS_kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RekamedisController extends Controller
{
    public function Index()
    {
        $menu = 'pendaftaran';
        return view('Rekamedis.pendaftaran', compact([
            'menu'
        ]));
    }
    public function riwayatPendaftaran()
    {
        $menu = 'riwayatpendaftaran';
        $date = $this->get_date();
        return view('Rekamedis.riwayatpendaftaran', compact([
            'menu', 'date'
        ]));
    }
    public function simpanPasienBaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data_mt_pasien = [
            'no_rm' => $this->get_rm(),
            'nik_bpjs' => $dataSet['nomoridentitas'],
            'nama_px' => $dataSet['namapasien'],
            'tempat_lahir' => $dataSet['tempatlahir'],
            'tgl_lahir' => $dataSet['tgllahir'],
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'propinsi' => $dataSet['idprovinsi'],
            'kabupaten' => $dataSet['idkabupaten'],
            'kecamatan' => $dataSet['idkecamatan'],
            'desa' => $dataSet['iddesa'],
            'alamat' => $dataSet['alamat'],
            'pic' => auth()->user()->id
        ];
        Mt_pasien::create($data_mt_pasien);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanPendaftaran(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $rm = $dataSet['rm'];
        $cek_rm = DB::connection('mysql2')->select('select * from ts_kunjungan where no_rm = ?', [$rm]);
        if (count($cek_rm) == 0) {
            $counter = 1;
        } else {
            foreach ($cek_rm as $c)
                $arr_counter[] = array(
                    'counter' => $c->counter
                );
            $last_count = max($arr_counter);
            $counter = $last_count['counter'] + 1;
        }
        if ($dataSet['idunit'] == '') {
            $data = [
                'kode' => 500,
                'message' => 'Unit Belum dipilih !'
            ];
            echo json_encode($data);
            die;
        }

        $data_kunjungan = [
            'counter' => $counter,
            'no_rm' => $dataSet['rm'],
            'kode_unit' => $dataSet['idunit'],
            'tgl_masuk' => $dataSet['tanggalkunjungan'] . ' ' . $this->get_time(),
            'status_kunjungan' => 1,
            'kode_penjamin' => 'P01',
            'pic' => auth()->user()->id
        ];
        TS_kunjungan::create($data_kunjungan);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanEditKunjungan(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }

        $data_edit = [
            'tgl_masuk' => $dataSet['tglmasuk'].' '.$this->get_time(),
            'kode_paramedis' => $dataSet['kodeparamedis'],
            'kode_unit' => $dataSet['kodeunit'],
            'status_kunjungan' => $dataSet['status_kunjungan'],
            'pic2' => auth()->user()->id
        ];
        ts_kunjungan::whereRaw('kode_kunjungan = ?', array($dataSet['kodekunjungan']))->update($data_edit);
        $data = [
            'kode' => 200,
            'message' => 'data berhasil diedit !'
        ];
        echo json_encode($data);
    }
    public function get_rm()
    {
        $y = DB::select('SELECT MAX(RIGHT(no_rm,6)) AS kd_max FROM mt_pasien');
        if (count($y) > 0) {
            foreach ($y as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('y') . $kd;
    }
    public function cariUnit(Request $request)
    {
        $key = $request['term'];
        $result = DB::connection('mysql2')->select("select * from mt_unit where nama_unit like '%$key%'");
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->nama_unit,
                    'id' => $row->kode_unit,
                );
            echo json_encode($arr_result);
        }
    }
    public function cariDokter(Request $request)
    {
        $key = $request['term'];
        $result = DB::connection('mysql2')->select("select * from mt_paramedis where nama_paramedis like '%$key%'");
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->nama_paramedis,
                    'id' => $row->kode_paramedis,
                );
            echo json_encode($arr_result);
        }
    }
    public function cariDesa(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) > 4) {
            $result = DB::select("SELECT a.id as id_desa,a.name as nama_desa,b.id as id_kecamatan,b.name as nama_kecamatan,c.id as id_kabupaten,c.name as nama_kabupaten,d.id as id_prov, d.name as nama_prov FROM mt_lokasi_villages a
        INNER JOIN mt_lokasi_districts b ON a.`district_id` = b.`id`
        INNER JOIN mt_lokasi_regencies c ON b.regency_id = c.id
        INNER JOIN mt_lokasi_provinces d on c.province_id = d.id
         WHERE a.name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->nama_desa . ' , KEC ' . $row->nama_kecamatan . ' , KAB ' . $row->nama_kabupaten . ' , PROV ' . $row->nama_prov,
                        'label2' => $row->nama_desa,
                        'nama_desa' => $row->nama_desa,
                        'kode_desa' => $row->id_desa,
                        'nama_kecamatan' => $row->nama_kecamatan,
                        'kode_kecamatan' => $row->id_kecamatan,
                        'nama_kabupaten' => $row->nama_kabupaten,
                        'kode_kabupaten' => $row->id_kabupaten,
                        'nama_prov2' => $row->nama_prov,
                        'kode_prov' => $row->id_prov,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariDataPasien(Request $request)
    {
        $rm = $request->rm;
        $id = $request->id;
        $nama = $request->nama;
        $alamat = $request->alamat;
        $mt_pasien = DB::connection('mysql2')->select("CALL WSP_PANGGIL_DATAPASIEN('$rm','$nama','$alamat','$id','')");
        return view('Rekamedis.tabel_pasien', compact([
            'mt_pasien'
        ]));
    }
    public function ambilFormPendaftaran(Request $request)
    {
        $rm = $request->rm;
        $pasien = DB::connection('mysql2')->select('select *,date(tgl_lahir) as tgl_lahir,fc_alamat(no_rm) as alamat from mt_pasien where no_rm = ?', [$rm]);
        $kunjungan = DB::connection('mysql2')->select('select counter,tgl_masuk,fc_nama_unit1(kode_unit) as nama_unit,status_kunjungan,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter from ts_kunjungan where no_rm = ? order by counter desc', [$rm]);
        $date = $this->get_date();
        return view('Rekamedis.form_pendaftaran', compact([
            'pasien', 'date', 'kunjungan'
        ]));
    }
    public function ambilRiwayatDaftar(Request $request)
    {
        $riwayat = DB::connection('mysql2')->select('SELECT kode_kunjungan,status_kunjungan,counter,tgl_masuk,no_rm,fc_nama_px(no_rm) AS nama_pasien
        ,fc_NAMA_PARAMEDIS1(kode_paramedis) AS nama_dokter
        ,pic,fc_nama_unit1(kode_unit) as nama_unit FROM ts_kunjungan WHERE DATE(tgl_masuk) BETWEEN ? AND ? ORDER BY kode_kunjungan DESC', [$request->awal, $request->akhir]);
        return view('Rekamedis.tabel_riwayat_pendaftaran',compact([
            'riwayat'
        ]));
    }
    public function ambilDetailKunjungan(Request $request)
    {
        $kunjungan = DB::connection('mysql2')->select('select kode_kunjungan,counter,tgl_masuk,date(tgl_masuk) as tgl_masuk2,fc_nama_unit1(kode_unit) as nama_unit,kode_unit,status_kunjungan,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,kode_paramedis from ts_kunjungan where kode_kunjungan = ? order by counter desc', [$request->kodekunjungan]);
        return view('Rekamedis.form_edit_kunjungan',compact([
            'kunjungan'
        ]));
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
}
