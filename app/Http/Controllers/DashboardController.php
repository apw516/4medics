<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satusehat_model;

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
        // $p = $v->get_province();
        // $idprov = 32;
        // $idkab = 3209;
        // $idkec = 320933;
        // $p = $v->get_kota_kabupaten($idprov);
        // $pv = $v->get_kecamatan($idkab);
        // $p = $v->get_desa($idkec);
        $p = $v->post_pasien_baru_nik();
        dd($p);
        if($p != 'Fail'){
            dd($p->data);
        }else{
            dd('gagal');
        }
    }
}
