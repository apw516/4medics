<?php

namespace App\Http\Controllers;

use App\Models\satu_sehat_mt_organization_ukp;
use Illuminate\Http\Request;
use App\Models\Satusehat_model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SatuSehatController extends Controller
{
    public function indexorganisasilokasi()
    {
        $menu = "organisasidanlokasi";
        return view('satusehat.index_organisai_lokasi', compact([
            'menu'
        ]));
    }
    public function ambil_form_add_ukp()
    {
        $menu = "organisasidanlokasi";
        return view('satusehat.form_add_ukp', compact([
            'menu'
        ]));
    }
    public function ambil_form_add_koord_poli()
    {
        $menu = "organisasidanlokasi";
        return view('satusehat.form_add_koord_ukp', compact([
            'menu'
        ]));
    }
    public function carisuborg_satusehat(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from satusehat_mt_organization_ukp where nama_ukp LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->nama_ukp,
                        'kode' => $row->id_satu_sehat,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariProvinsi(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from mt_lokasi_provinsi_satu_sehat where name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->name,
                        'kode' => $row->code,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariKabupaten(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from mt_lokasi_kabupaten_satu_sehat where name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->name,
                        'kode' => $row->code,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariKecamatan(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from mt_lokasi_kecamatan_satu_sehat where name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->name,
                        'kode' => $row->code,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function cariDesa(Request $request)
    {
        $key = $request['term'];
        if (strlen($key) >= 4) {
            $result = DB::select("select * from mt_lokasi_desa_satu_sehat where name LIKE '%$key%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->name,
                        'kode' => $row->code,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function ambildatapartner()
    {
        $v = new Satusehat_model();
        $p = $v->organizationByPartOf();
        if ($p['code'] == 200) {
            // dd($p);
            return view('satusehat.tabel_partner_of_4medicss', compact([
                'p'
            ]));
        } else {
        }
    }
    public function ambil_loaction_by_orgId(Request $request)
    {
        $v = new Satusehat_model();
        $p = $v->organizationByPartOf2($request->idorganization);
        if ($p['code'] == 200) {
            return view('satusehat.tabel_partner_of_4medics_2', compact([
                'p'
            ]));
        } else {
        }
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
    public function simpanukpbaru(Request $request)
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
                'nama_ukp' => $dataSet['namaukp'],
                'nomor_telp' => $dataSet['nomortelepon'],
                'email' => $dataSet['email'],
                'website' => $dataSet['website'],
                'alamat' => $dataSet['alamat'],
                'kota' => $dataSet['kota'],
                'kode_pos' => $dataSet['kodepos'],
                'provinsi' => $dataSet['kodeprovinsi'],
                'kabupaten' => $dataSet['kodekabupaten'],
                'kecamatan' => $dataSet['kodekecamatan'],
                'desa' => $dataSet['kodedesa'],
                'nama_display' => $dataSet['namadisplay'],
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
    public function simpankoordbaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $v = new Satusehat_model();
        $p = $v->CreateOrganizationKoord($dataSet);
        if ($p['code'] == 200) {
            $dataukp_sukses = [
                'id_satu_sehat' => $p['id'],
                'nama_ukp' => $dataSet['namaukp'],
                'nomor_telp' => $dataSet['nomortelepon'],
                'email' => $dataSet['email'],
                'website' => $dataSet['website'],
                'alamat' => $dataSet['alamat'],
                'kota' => $dataSet['kota'],
                'kode_pos' => $dataSet['kodepos'],
                'provinsi' => $dataSet['kodeprovinsi'],
                'kabupaten' => $dataSet['kodekabupaten'],
                'kecamatan' => $dataSet['kodekecamatan'],
                'desa' => $dataSet['kodedesa'],
                // 'nama_display' => $dataSet['namadisplay'],
                'status' => '1',
                'tgl_entry' => $this->get_now()
            ];
            dd($dataukp_sukses);
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
}
