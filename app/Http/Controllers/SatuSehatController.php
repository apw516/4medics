<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satusehat_model;

class SatuSehatController extends Controller
{
    public function indexPartner4medics()
    {
        $menu = "partner4medics";
        return view('satusehat.index_partner_4medics', compact([
            'menu'
        ]));
    }
    public function ambildatapartner()
    {
        $v = new Satusehat_model();
        $p = $v->organizationByPartOf();
        if($p['code'] == 200){
            // dd($p);
            return view('satusehat.tabel_partner_of_4medicss',compact([
                'p'
            ]));
        }else{

        }
    }
    public function ambil_loaction_by_orgId(Request $request)
    {
        $v = new Satusehat_model();
        $p = $v->organizationByPartOf2($request->idorganization);
        if($p['code'] == 200){
            return view('satusehat.tabel_partner_of_4medics_2',compact([
                'p'
            ]));
        }else{

        }
    }
}
