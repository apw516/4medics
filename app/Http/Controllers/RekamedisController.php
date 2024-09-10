<?php

namespace App\Http\Controllers;

use App\Models\Log_mt_pasien;
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
        $date = $this->get_date();
        return view('Rekamedis.pendaftaran', compact([
            'menu','date'
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
        $rm = $this->get_rm();
        $data_mt_pasien = [
            'no_rm' => $rm,
            'nik_bpjs' => $dataSet['nomoridentitas'],
            'nama_px' => $dataSet['namapasien'],
            'tempat_lahir' => $dataSet['tempatlahir'],
            'tgl_lahir' => $dataSet['tgllahir'],
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'propinsi' => $dataSet['idprovinsi'],
            'kabupaten' => $dataSet['idkabupaten'],
            'kecamatan' => $dataSet['idkecamatan'],
            'desa' => $dataSet['iddesa'],
            'kode_propinsi' => $dataSet['idprovinsi'],
            'kode_kabupaten' => $dataSet['idkabupaten'],
            'kode_kecamatan' => $dataSet['idkecamatan'],
            'kode_desa' => $dataSet['iddesa'],
            'alamat' => $dataSet['alamat'],
            'pic' => auth()->user()->id
        ];
        // dd($data_mt_pasien);
        Mt_pasien::create($data_mt_pasien);
        $data = [
            'kode' => 200,
            'message' => 'sukses',
            'rm' => $rm
        ];
        echo json_encode($data);
    }
    public function simpanEditPasien(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data_mt_pasien = [
            'nik_bpjs' => $dataSet['nomoridentitas'],
            'nama_px' => $dataSet['namapasien'],
            'tempat_lahir' => $dataSet['tempatlahir'],
            'tgl_lahir' => $dataSet['tgllahir'],
            'jenis_kelamin' => $dataSet['jeniskelamin'],
            'propinsi' => trim($dataSet['idprovinsi2']),
            'kabupaten' => trim($dataSet['idkabupaten2']),
            'kecamatan' => trim($dataSet['idkecamatan2']),
            'desa' => trim($dataSet['iddesa2']),
            'kode_propinsi' => trim($dataSet['idprovinsi2']),
            'kode_kabupaten' => trim($dataSet['idkabupaten2']),
            'kode_kecamatan' => trim($dataSet['idkecamatan2']),
            'kode_desa' => trim($dataSet['iddesa2']),
            'alamat' => $dataSet['alamat'],
            'update_date' => $this->get_now(),
            'update_by' => auth()->user()->id,
            'pic' => auth()->user()->id
        ];
        Mt_pasien::whereRaw('no_rm = ?', array($dataSet['nomorrm']))->update($data_mt_pasien);
        $data = [
            'kode' => 200,
            'message' => 'sukses',
            'rm' => $dataSet['nomorrm']
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
            'tgl_masuk' => $dataSet['tglmasuk'] . ' ' . $this->get_time(),
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
        if($y[0]->kd_max >= 999999){
            $y = DB::connection('mysql2')->select('SELECT MAX(RIGHT(no_rm,6)) AS kd_max FROM mt_pasien where LEFT(no_rm,2) = ?',['01']);
            if (count($y) > 0) {
                foreach ($y as $k) {
                    $tmp = ((int) $k->kd_max) + 1;
                    $kd = sprintf("%06s", $tmp);
                }
            } else {
                $kd = "000001";
            }
            date_default_timezone_set('Asia/Jakarta');
            return '01'.$kd;
        }else{
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
        // dd($request);
        $key = $request['desa'];
        $kec = $request['id'];
        if (strlen($key) > 4) {
            $result = DB::select("SELECT a.id as id_desa,a.name as nama_desa,b.id as id_kecamatan,b.name as nama_kecamatan,c.id as id_kabupaten,c.name as nama_kabupaten,d.id as id_prov, d.name as nama_prov FROM mt_lokasi_villages a
         JOIN mt_lokasi_districts b ON a.`district_id` = b.`id`
         JOIN mt_lokasi_regencies c ON b.regency_id = c.id
         JOIN mt_lokasi_provinces d on c.province_id = d.id
        WHERE b.id = '$kec' and a.name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->nama_desa.' | '. $row->nama_kecamatan,
                        'kode' => $row->id_desa,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariProvinsi(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from mt_lokasi_provinces where name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->name,
                        'kode' => $row->id,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariKabupaten(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from mt_lokasi_regencies where name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->name,
                        'kode' => $row->id,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariKecamatan(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select *,a.name as nama_kecamatan,b.name as nama_kabupaten,a.id as id_kec from mt_lokasi_districts a inner join mt_lokasi_regencies b on a.regency_id = b.id where a.name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->nama_kecamatan . ' ' . $row->nama_kabupaten,
                        'kode' => $row->id_kec,
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
    public function ambilFormEditPasien(Request $request)
    {
        $rm = $request->rm;
        $pasien = DB::connection('mysql2')->select('select *,date(tgl_lahir) as tgl_lahir,fc_alamat(no_rm) as alamat from mt_pasien where no_rm = ?', [$rm]);
        $prov = $pasien[0]->kode_propinsi;
        $kab = $pasien[0]->kode_kabupaten;
        $kec = $pasien[0]->kode_kecamatan;
        $des = $pasien[0]->kode_desa;
        $provinsi = DB::select('select * from mt_lokasi_provinces where id = ?',[$prov]);
        $kabupaten = DB::select('select * from mt_lokasi_regencies where id = ?',[$kab]);
        $kecamatan = DB::select('select * from mt_lokasi_districts where id = ?',[$kec]);
        $desa = DB::select('select * from mt_lokasi_villages where id = ?',[$des]);
        $date = $this->get_date();
        return view('Rekamedis.form_edit_pasien', compact([
            'pasien','provinsi','kabupaten','kecamatan','desa'
        ]));
    }
    public function ambilRiwayatDaftar(Request $request)
    {
        $riwayat = DB::connection('mysql2')->select('SELECT kode_kunjungan,status_kunjungan,counter,tgl_masuk,no_rm,fc_nama_px(no_rm) AS nama_pasien
        ,fc_NAMA_PARAMEDIS1(kode_paramedis) AS nama_dokter
        ,pic,fc_nama_unit1(kode_unit) as nama_unit FROM ts_kunjungan WHERE DATE(tgl_masuk) BETWEEN ? AND ? ORDER BY kode_kunjungan DESC', [$request->awal, $request->akhir]);
        return view('Rekamedis.tabel_riwayat_pendaftaran', compact([
            'riwayat'
        ]));
    }
    public function ambilRiwayatDaftarToday(Request $request)
    {
        $riwayat = DB::connection('mysql2')->select('SELECT kode_kunjungan,status_kunjungan,counter,tgl_masuk,no_rm,fc_nama_px(no_rm) AS nama_pasien
        ,fc_NAMA_PARAMEDIS1(kode_paramedis) AS nama_dokter
        ,pic,fc_nama_unit1(kode_unit) as nama_unit FROM ts_kunjungan WHERE DATE(tgl_masuk) = ? ORDER BY kode_kunjungan DESC', [$request->tanggalriwayat]);
        return view('Rekamedis.tabel_riwayat_pendaftaran_today', compact([
            'riwayat'
        ]));
    }
    public function ambilDetailKunjungan(Request $request)
    {
        $kunjungan = DB::connection('mysql2')->select('select kode_kunjungan,counter,tgl_masuk,date(tgl_masuk) as tgl_masuk2,fc_nama_unit1(kode_unit) as nama_unit,kode_unit,status_kunjungan,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,kode_paramedis from ts_kunjungan where kode_kunjungan = ? order by counter desc', [$request->kodekunjungan]);
        return view('Rekamedis.form_edit_kunjungan', compact([
            'kunjungan'
        ]));
    }
    public function indexMasterPasien(){
        $menu = 'masterpasien';
        return view('Rekamedis.index_master_pasien',compact([
            'menu'
        ]));
    }
    public function dataMasterPasien(){
        $data = DB::select('select * from mt_pasien order by tgl_entry limit 1000' );
        return view('Rekamedis.tabel_master_pasien',compact([
            'data'
        ]));
    }
    public function hapusPasien(request $request){
        $datapasien = DB::select('select *,fc_alamat(no_rm) as alamat2 from mt_pasien where no_rm = ?',[$request->rm]);
        $log = [
            'no_rm' => $request->rm,
            'catatan' => 'data pasien '. $datapasien[0]->nama_px .' alamat '. $datapasien[0]->alamat2 . ' data dihapus oleh id user : '.auth()->user()->id. ' Nama User : '. auth()->user()->nama,
            'tgl_edit' => $this->get_now()
        ];
        Log_mt_pasien::create($log);
        DB::table('mt_pasien')->where('no_rm', $request->rm)->delete();
        $data = [
            'kode' => 200,
            'message' => 'sukses,data berhasil dihapus ...'
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
}
