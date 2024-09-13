<?php

namespace App\Http\Controllers;

use App\Models\master_paramedis;
use App\Models\master_unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterController extends Controller
{
    public function indexMasterPasien()
    {
        $menu = "masterpasien";
        return view('Master.index_master_pasien', compact([
            'menu'
        ]));
    }
    public function indexMasterUnit()
    {
        $menu = "masterunit";
        return view('Master.index_master_unit', compact([
            'menu'
        ]));
    }
    public function indexMasterUser()
    {
        $menu = "masteruser";
        return view('Master.index_master_user', compact([
            'menu'
        ]));
    }
    public function indexMasterPegawai()
    {
        $menu = "masterpegawai";
        $mt_unit = db::select('select * from mt_unit');
        return view('Master.index_master_pegawai', compact([
            'menu','mt_unit'
        ]));
    }
    public function ambilMaterUnit()
    {
        $mt_unit = db::select('select * from mt_unit');
        return view('Master.tb_master_unit', compact([
            'mt_unit'
        ]));
    }
    public function ambilBerkasErm(Request $request)
    {
        $erm = db::select('select *,fc_nama_unit1(a.kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(a.kode_paramedis) as nama_dokter from ts_kunjungan a left outer join erm_assesmen_medis b on a.kode_kunjungan = b.kodekunjungan where a.no_rm = ? order by a.counter desc',[$request->rm]);
        $pasien = DB::connection('mysql2')->select('select *,date(tgl_lahir) as tgl_lahir,fc_alamat(no_rm) as alamat from mt_pasien where no_rm = ?', [$request->rm]);
        return view('Master.berkas_erm', compact([
            'erm','pasien'
        ]));
    }
    public function ambilMasterPasien(Request $request)
    {
        $rm = $request->rm;
        $id = $request->id;
        $nama = $request->nama;
        $alamat = $request->alamat;
        $pasien = DB::connection('mysql2')->select("CALL WSP_PANGGIL_DATAPASIEN('$rm','$nama','$alamat','$id','')");
        return view('Master.tb_master_pasien', compact([
            'pasien'
        ]));
    }
    public function ambilMaterUser()
    {
        $user = db::select('select * from user');
        return view('Master.tb_master_user', compact([
            'user'
        ]));
    }
    public function ambilMaterPegawai()
    {
        $paramedis = db::select('select * from mt_paramedis a left outer join mt_unit b on a.unit = b.kode_unit');
        return view('Master.tb_master_paramedis', compact([
            'paramedis'
        ]));
    }
    public function simpanUnitBaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $kode_unit = db::select('select * from mt_unit where group_unit = ? and id = (select max(id) from mt_unit where group_unit = ?)', [$dataSet['tipeunit'], $dataSet['tipeunit']]);
        $kode_unit = $kode_unit[0]->kode_unit + 1;
        $data2 = [
            'kode_unit' => $kode_unit,
            'nama_unit' => strtoupper($dataSet['namaunit']),
            'group_unit' => $dataSet['tipeunit'],
        ];
        master_unit::create($data2);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanPegawaiBaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $kode_paramedis = $this->get_kode_paramedis();
        $DATA = [
            'kode_paramedis' => $kode_paramedis,
            'nama_paramedis' => $dataSet['namapegawai'],
            'unit' => $dataSet['unitkerja'],
            'preffix' => $dataSet['hakakses'],
        ];
        master_paramedis::create($DATA);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanUpdateUnit(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data2 = [
            'nama_unit' => strtoupper($dataSet['editnamaunit']),
            'group_unit' => $dataSet['edittipeunit'],
        ];
        master_unit::whereRaw('id = ?', array($dataSet['idunit']))->update($data2);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanUpdateUser(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data2 = [
            'username' => $dataSet['username'],
            'kode_paramedis' => $dataSet['kode_paramedis'],
            'nama' => $dataSet['namalengkap'],
            'hak_akses' => $dataSet['hakakses'],
            'unit' => $dataSet['unit'],
            'status' => $dataSet['status']
        ];
        User::whereRaw('id = ?', array($dataSet['iduser']))->update($data2);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanUpdatePegawai(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $DATA = [
            'nama_paramedis' => $dataSet['namapegawai'],
            'unit' => $dataSet['unitkerja'],
            'preffix' => $dataSet['hakakses'],
        ];
        master_paramedis::whereRaw('ID = ?', array($dataSet['idpegawai']))->update($DATA);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function ambilDetailUnit(request $request)
    {
        $id = $request->idunit;
        $mt_unit = db::select('select * from mt_unit where id = ?', [$id]);
        return view('Master.form_edit_unit', compact([
            'mt_unit'
        ]));
    }
    public function ambilDetailUser(request $request)
    {
        $id = $request->iduser;
        $mt_unit = db::select('select * from mt_unit');
        $user = db::select('select * from user where id = ?', [$id]);
        return view('Master.form_edit_user', compact([
            'user',
            'mt_unit'
        ]));
    }
    public function ambilDetailPegawai(request $request)
    {
        $id = $request->idpegawai;
        $mt_unit = db::select('select * from mt_unit');
        $pegawai = db::select('select * from mt_paramedis where ID = ?', [$id]);
        return view('Master.form_edit_pegawai', compact([
            'pegawai',
            'mt_unit'
        ]));
    }
    public function get_kode_paramedis()
    {

        $q = DB::select('SELECT ID,kode_paramedis,RIGHT(kode_paramedis,3) AS kd_max  FROM mt_paramedis
        ORDER BY ID DESC
            LIMIT 1');
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'DOK' .$kd;
    }
}
