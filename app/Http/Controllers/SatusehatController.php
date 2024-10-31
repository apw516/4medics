<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SatusehatController extends Controller
{
    public function indexMasterOrganization()
    {
        $menu = 'masterorganization';
        return view('Satusehat.indexmasterorganization',compact([
            'menu'
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
                    'id' => $row->bps_code,
                );
            echo json_encode($arr_result);
        }
    }
}
