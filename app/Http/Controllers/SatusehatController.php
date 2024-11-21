<?php

namespace App\Http\Controllers;

use App\Models\erm_assesmen_dokter;
use App\Models\satu_sehat_mt_organization_ukp;
use App\Models\satu_sehat_mt_poli;
use App\Models\satu_sehat_mt_poli_org;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Satusehat_model;
use App\Models\TS_kunjungan;

class SatusehatController extends Controller
{
    public function indexMasterOrganization()
    {
        $menu = 'masterorganization';
        return view('Satusehat.indexmasterorganization',compact([
            'menu'
        ]));
    }
    public function indexMasterKunjungan()
    {
        $menu = 'masterkunjungan';
        $date = $this->get_date();
        return view('Satusehat.indexmasterkunjungan',compact([
            'menu','date'
        ]));
    }
    public function indexMasterPasien()
    {
        $menu = 'masterpasien';
        return view('Satusehat.indexmasterorganization',compact([
            'menu'
        ]));
    }
    public function Ambildataukp()
    {
        $DATA = DB::select('select * from satusehat_mt_organization_ukp');
        $tipe = DB::select('select * from satusehat_mt_location_physical_type');
        return view('Satusehat.tabel_data_ukp',compact([
            'DATA','tipe'
        ]));
    }
    public function AmbilDataKunjungan(Request $request)
    {
        $awal = $request->tglawal;
        $akhir = $request->tglakhir;
        $data = DB::connection('mysql2')->select('select counter,fc_nama_px(no_rm) as nama_pasien,no_rm,kode_kunjungan,tgl_masuk,fc_nama_unit1(kode_unit) as nama_unit,fc_NAMA_PARAMEDIS1(kode_paramedis) as nama_dokter,fc_alamat(no_rm) as alamat,bridging_satu_sehat from ts_kunjungan where date(tgl_masuk) between ? and ?', [$awal, $akhir]);
        return view('Satusehat.tabel_data_kunjungan',compact([
            'data'
        ]));
    }
    public function Ambildatapoli(Request $request)
    {
        $DATA = DB::select('select * from satusehat_mt_poli where id_organization_tabel = ?',[$request->idtabel]);
        $DATA2 = DB::select('select * from satusehat_mt_poli_org where id_organization_tabel = ?',[$request->idtabel]);
        return view('Satusehat.tabel_poli_satu_sehat',compact([
            'DATA','DATA2'
        ]));
    }
    public function Simpandataukp(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $v = new Satusehat_model();
        $p = $v->CreateOrganizationUKP($dataSet);
        if ($p['code'] == 200) {
            $dataukp_sukses = [
                'id_satu_sehat' => $p['id'],
                'nama_ukp' => $dataSet['namaorg'],
                'nomor_telp' => $dataSet['notelporg'],
                'email' => $dataSet['email'],
                'website' => $dataSet['website'],
                'alamat' => $dataSet['alamat'],
                'kota' => $dataSet['kota'],
                'kode_pos' => $dataSet['kodepos'],
                'provinsi' => $dataSet['kodeprovinsiukp'],
                'kabupaten' => $dataSet['kodekabupatenukp'],
                'kecamatan' => $dataSet['kodekecamatanukp'],
                'desa' => $dataSet['kodedesaukp'],
                'nama_display' => $dataSet['displayorg'],
                'status' => '1',
                'tgl_entry' => $this->get_now()
            ];
            satu_sehat_mt_organization_ukp::create($dataukp_sukses);
           $data = [
                'kode' => 200,
                'message' => 'sukses,data berhasil disimpan ...'
            ];
            echo json_encode($data);
            die;
        } else {
            $data = [
                'kode' => 500,
                'message' => $p['status']
            ];
            echo json_encode($data);
            die;
        }

    }
    public function KirimKunjunganPasien(Request $request)
    {
        $kodekunjungan = $request->kode;
        $ts_kunjungan = db::select('select * from ts_kunjungan where kode_kunjungan = ?',[$kodekunjungan]);
        $mtpasien = db::select('select * from mt_pasien where no_rm = ?',[$ts_kunjungan[0]->no_rm]);
        $mtunit = db::select('select * from mt_unit where kode_unit = ?',[$ts_kunjungan[0]->kode_unit]);
        $kunjungansatusehat = [
            'namapasien'=>$mtpasien[0]->nama_px,
            'idsatusehat'=>$mtpasien[0]->id_satu_sehat,
            'idpoli'=>$mtunit[0]->loc_ihs_kode,
            'namapoli'=>$mtunit[0]->nama_unit,
            'iddokter'=>'N10000001',
            'namadokter'=>'Voigt',
        ];
        $id_kunjungan_satu_sehat = 0;
        $status = 0;
        if($mtpasien[0]->status_satu_sehat == 1){
            $v = new Satusehat_model();
            $p = $v->createEncounter($kunjungansatusehat);
            if($p['code'] == 200){
                $id_kunjungan_satu_sehat = $p['data']->id;
                $status = 1;
            }
            $data_kunjungan = [
                'enc_ihs_kode' => $id_kunjungan_satu_sehat,
                'bridging_satu_sehat' => $status,
            ];
            TS_kunjungan::whereRaw('kode_kunjungan = ?', array($kodekunjungan))->update($data_kunjungan);
            if($id_kunjungan_satu_sehat != 0){
                $assesmen = db::select('select * from erm_assesmen_medis where kodekunjungan = ?',[$kodekunjungan]);
                $datasatusehat = [
                    'idpasien' => $mtpasien[0]->id_satu_sehat,
                    'namapasien' => $mtpasien[0]->nama_px,
                    'counterid' => $id_kunjungan_satu_sehat,
                    'iddokter' => 'N10000001',
                    'namadokter' => 'Voigt',
                    'keluhan' => $assesmen[0]->subject,
                ];
                $v = new Satusehat_model();
                $id_kunjungan_satu_sehat2 = 0;
                $p2 = $v->anamnesisKeluhanUtama($datasatusehat);
                if ($p['code'] == 200) {
                    $id_kunjungan_satu_sehat2 = $p2['data']->id;
                }
                $data_pemeriksaan = [
                    'id_satu_sehat' => $id_kunjungan_satu_sehat2
                ];
                erm_assesmen_dokter::whereRaw('kodekunjungan = ?', array($kodekunjungan))->update($data_pemeriksaan);
            }
            if($p['code'] == 200){
                $data = [
                    'kode' => 200,
                    'message' => 'data berhasil dikirim !'
                ];
                echo json_encode($data);
            }else{
                $data = [
                    'kode' => 500,
                    'message' => 'gagal kirim satu sehat !'
                ];
                echo json_encode($data);
            }
        }else{
            $data = [
                'kode' => 500,
                'message' => 'Pasien tidak memiliki id satu sehat'
            ];
            echo json_encode($data);
        }
    }
    public function PulangkanPasien(request $request)
    {
        $kodekunjungan = $request->kodekunjungan;
        $ts_kunjungan = db::select('select * from ts_kunjungan where kode_kunjungan = ?',[$kodekunjungan]);
        $mtpasien = db::select('select * from mt_pasien where no_rm = ?',[$ts_kunjungan[0]->no_rm]);
        $mtunit = db::select('select * from mt_unit where kode_unit = ?',[$ts_kunjungan[0]->kode_unit]);
        if($ts_kunjungan[0]->bridging_satu_sehat == 1){
            $kunjungansatusehat = [
                'namapasien'=>$mtpasien[0]->nama_px,
                'idsatusehat'=>$mtpasien[0]->id_satu_sehat,
                'idsatusehat_kunjungan'=>$ts_kunjungan[0]->enc_ihs_kode,
                'idpoli'=>$mtunit[0]->loc_ihs_kode,
                'namapoli'=>$mtunit[0]->nama_unit,
                'iddokter'=>'N10000001',
                'namadokter'=>'Voigt',
            ];
            $v = new Satusehat_model();
            $p = $v->updatePulang($kunjungansatusehat);
            dd($p);
        }
        $data = [
            'kode' => 500,
            'message' => 'Pasien tidak memiliki id satu sehat'
        ];
        echo json_encode($data);
    }
    public function Simpandatapoli(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data_organization = db::select('select * from satusehat_mt_organization_ukp where id = ?',[$dataSet['idtable']]);
        $data_tipe = db::select('select * from satusehat_mt_location_physical_type where code = ?',[$dataSet['tipe']]);
        $v = new Satusehat_model();
        $tipe = $data_tipe[0]->display;
        $data_org = [
            'email' => $data_organization[0]->email,
            'no_telp' => $data_organization[0]->nomor_telp,
            'website' => $data_organization[0]->website,
        ];
        $p = $v->CreateOrganizationPoli($dataSet,$data_org,$tipe);
        if ($p['code'] == 200) {
            $latitude = $dataSet['posisilatitude'];
            $longitude = $dataSet['posisilongitude'];
            $altitude = $dataSet['posisialtitude'];
            $data_poli_sukses = [
                'nama_poli' => $dataSet['namapoli'],
                'deskripsi' => $dataSet['deskripsi'],
                'id_poli_satu_sehat' => $p['id'],
                'organization_id_satu_sehat' => $dataSet['idorganization'],
                'id_organization_tabel' => $dataSet['idtable'],
                'altitude'=> $altitude,
                'latitude'=> $latitude,
                'longitude'=> $longitude,
                'status' => '1',
                'tgl_entry' => $this->get_now()
            ];
            satu_sehat_mt_poli::create($data_poli_sukses);
           $data = [
                'kode' => 200,
                'message' => 'sukses,data berhasil disimpan ...'
            ];
            echo json_encode($data);
            die;
        } else {
            $data = [
                'kode' => 500,
                'message' => $p['status']
            ];
            echo json_encode($data);
            die;
        }

    }
    public function Simpandatakoordpoli(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $data_org = db::select('select * from satusehat_mt_organization_ukp where id = ?',[$dataSet['idtabel']]);
        $data_org2 = [
            'kode' => $data_org[0]->id_satu_sehat,
            'display' => $data_org[0]->nama_display
        ];
        $v = new Satusehat_model();
        $p = $v->CreateOrganizationKoord($dataSet,$data_org2);
        if ($p['code'] == 200) {
            $data_poli_sukses = [
                'nama' => $dataSet['namalengkap'],
                'id_satu_sehat' => $p['id'],
                'organization_id_satu_sehat' => $dataSet['idorganization2'],
                'id_organization_tabel' => $dataSet['idtabel'],
                'no_telp' => $dataSet['notelp'],
                'email' => $dataSet['email'],
                'alamat' => $dataSet['alamatjalan'],
                'kota' => $dataSet['alamatkota'],
                'kode_pos' => $dataSet['kodepos'],
                'provinsi' => $dataSet['kodeprovinsiorg'],
                'kabupaten' => $dataSet['kodekabupatenorg'],
                'kecamatan' => $dataSet['kodekecamatanorg'],
                'desa' => $dataSet['kodedesaorg'],
                'status' => '1',
                'tgl_entry' => $this->get_now()
            ];
            satu_sehat_mt_poli_org::create($data_poli_sukses);
           $data = [
                'kode' => 200,
                'message' => 'sukses,data berhasil disimpan ...'
            ];
            echo json_encode($data);
            die;
        } else {
            $data = [
                'kode' => 500,
                'message' => $p['status']
            ];
            echo json_encode($data);
            die;
        }

    }
    public function Cariprovinsi(Request $request)
    {
        $key = $request['term'];
        $result = DB::connection('mysql')->select("select * from mt_lokasi_provinsi_satu_sehat where name like '%$key%'");
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->name,
                    'id' => $row->bps_code,
                );
            echo json_encode($arr_result);
        }
    }
    public function Carikabupaten(Request $request)
    {
        $key = $request['kabupaten'];
        $idprov = $request['id'];
        $result = DB::connection('mysql')->select("select * from mt_lokasi_kabupaten_satu_sehat where name like '%$key%' and parent_code = ?",[$idprov]);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->name,
                    'id' => $row->bps_code,
                );
            echo json_encode($arr_result);
        }
    }
    public function Carikecamatan(Request $request)
    {
        $key = $request['kecamatan'];
        $idkab = $request['id'];
        $result = DB::connection('mysql')->select("select * from mt_lokasi_kecamatan_satu_sehat where name like '%$key%' and parent_code = ?",[$idkab]);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->name,
                    'id' => $row->code,
                );
            echo json_encode($arr_result);
        }
    }
    public function Caridesa(Request $request)
    {
        $key = $request['desa'];
        $idkec = $request['id'];
        $result = DB::connection('mysql')->select("select * from mt_lokasi_desa_satu_sehat where name like '%$key%' and parent_code = ?",[$idkec]);
        if (count($result) > 0) {
            foreach ($result as $row)
                $arr_result[] = array(
                    'label' => $row->name,
                    'id' => $row->code,
                );
            echo json_encode($arr_result);
        }
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
