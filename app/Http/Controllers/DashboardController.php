<?php

namespace App\Http\Controllers;

use App\Models\mt_lokasi_desa_satu_sehat;
use App\Models\mt_lokasi_kabupaten_satu_sehat;
use App\Models\mt_lokasi_kecamatan_satu_sehat;
use Illuminate\Http\Request;
use App\Models\Satusehat_model;
use App\Models\mt_provinsi_satu_sehat;

class DashboardController extends Controller
{
    Public function Index()
    {
        $menu = 'dashboard';
        return view('Dashboard.Index',compact([
            'menu'
        ]));
    }
    public function Index_test_satu_Sehat_master_wilayah()
    {
        $v = new Satusehat_model();
        $p = $v->get_province();
        // dd($p);
        // foreach($p->data as $p){
        //     $data = [
        //         'code' => $p->code,
        //         'parent_code' => $p->parent_code,
        //         'bps_code' => $p->bps_code,
        //         'name' => $p->name,
        //     ];
        //     mt_provinsi_satu_sehat::create($data);
        // }
        // dd($data);
        // $idprov = 32;
        $idkab = 3209;
        $idkec = 320904;
        // $p = $v->get_kota_kabupaten($idprov);
        //   foreach($p->data as $p){
        //     $data = [
        //         'code' => $p->code,
        //         'parent_code' => $p->parent_code,
        //         'bps_code' => $p->bps_code,
        //         'name' => $p->name,
        //     ];
        //     mt_lokasi_kabupaten_satu_sehat::create($data);
        // }
        // dd($p);
        // $p = $v->get_kecamatan($idkab);
        // // dd($p);
        // foreach($p->data as $p){
        //     $data = [
        //         'code' => $p->code,
        //         'parent_code' => $p->parent_code,
        //         'bps_code' => $p->bps_code,
        //         'name' => $p->name,
        //     ];
        //     mt_lokasi_kecamatan_satu_sehat::create($data);
        // }
        // dd($p);
        $p = $v->get_desa($idkec);
         foreach($p->data as $p){
            $data = [
                'code' => $p->code,
                'parent_code' => $p->parent_code,
                'bps_code' => $p->bps_code,
                'name' => $p->name,
            ];
            mt_lokasi_desa_satu_sehat::create($data);
        }
        dd($p);
        $p = $v->post_pasien_baru_nik();
        if($p != 'Fail'){
            dd($p->data);
        }else{
            dd('gagal');
        }
    }
}
