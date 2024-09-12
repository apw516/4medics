<?php

namespace App\Http\Controllers;

use App\Models\master_unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterController extends Controller
{
    public function indexMasterUnit()
    {
        $menu = "masterunit";
        return view('Master.index_master_unit',compact([
            'menu'
        ]));
    }
    public function ambilMaterUnit()
    {
        $mt_unit = db::select('select * from mt_unit');
        return view('Master.tb_master_unit',compact([
            'mt_unit'
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
        $kode_unit = db::select('select * from mt_unit where group_unit = ? and id = (select max(id) from mt_unit where group_unit = ?)',[$dataSet['tipeunit'],$dataSet['tipeunit']]);
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
    public function ambilDetailUnit(request $request){
        $id = $request->idunit;
        $mt_unit = db::select('select * from mt_unit where id = ?',[$id]);
        return view('Master.form_edit_unit',compact([
            'mt_unit'
        ]));
    }
}
