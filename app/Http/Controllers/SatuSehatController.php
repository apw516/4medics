<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SatuSehatController extends Controller
{
    public function indexDataPasien()
    {
        $menu = 'datapasien';
        return view('Satusehat.index_data_pasien',compact([
            'menu'
        ]));
    }
    public function ambilDataPasienIhs()
    {
        return view('Satusehat.tabel_data_pasien');
    }
}
