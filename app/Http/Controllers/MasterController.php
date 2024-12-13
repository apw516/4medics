<?php

namespace App\Http\Controllers;

use App\Models\ihs_ts_kunjungan;
use App\Models\ihs_mt_pasien;
use App\Models\ihs_status_encounter;
use App\Models\master_paramedis;
use App\Models\master_unit;
use App\Models\mt_lokasi_desa_satu_sehat;
use App\Models\Satusehat_model;
use App\Models\master_tarif;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class MasterController extends Controller
{
    public function indexMasterPasien()
    {
        $menu = "masterpasien";
        return view('Master.index_master_pasien', compact([
            'menu'
        ]));
    }
    public function indexMasterLokasi()
    {
        $menu = "masterlokasi";
        return view('Master.index_master_lokasi', compact([
            'menu'
        ]));
    }
    public function indexMasterKunjungan()
    {
        $menu = "masterkunjungan";
        $date = $this->get_date();
        return view('Master.index_master_kunjungan', compact([
            'menu',
            'date'
        ]));
    }
    public function get_date()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $now = $date;
        return $now;
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
            'menu',
            'mt_unit'
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
        $erm = db::select('select * from ts_kunjungan where no_rm = ?', [$request->rm]);
        $pasien = DB::connection('mysql2')->select('select *,date(tgl_lahir) as tgl_lahir,fc_alamat(no_rm) as alamat from mt_pasien where no_rm = ?', [$request->rm]);
        return view('Master.berkas_erm', compact([
            'erm',
            'pasien'
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
    public function simpanUpdateTarif(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $DATA = [
            'nama_tarif' => $dataSet['namatarif'],
            'tarif' => $dataSet['tarif'],
            'jenis_tarif' => $dataSet['jenistarif'],
            'kode_unit' => $dataSet['unittarif'],
            'status' => $dataSet['status'],
        ];
        master_tarif::whereRaw('id = ?', array($dataSet['idtarif']))->update($DATA);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanTarifBaru(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $DATA = [
            'nama_tarif' => $dataSet['namatarif'],
            'tarif' => $dataSet['tarif'],
            'jenis_tarif' => $dataSet['jenistarif'],
            'kode_unit' => $dataSet['unittarif'],
        ];
        master_tarif::create($DATA);
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
            'ihs_code' => $dataSet['ihs_code'],
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
    public function ambilDetailTarif(request $request)
    {
        $id = $request->idtarif;
        $mt_unit = db::select('select * from mt_unit');
        $mt_tarif = db::select('select * from mt_tarif_baru where id = ?', [$id]);
        return view('Master.form_edit_tarif', compact([
            'mt_tarif',
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
        return 'DOK' . $kd;
    }
    public function kirimPasienSatuSehat(Request $request)
    {
        $rm = $request->rm;
        $data = db::select('select * from ihs_mt_pasien where no_rm =?', [$rm]);
        $datasatusehat = [
            'nik' => $data[0]->nik,
            'namapasien' => $data[0]->nama_pasien,
            'notelp' => '-',
            'normh' => '-',
            'email' => '-',
            'jeniskelamin' => $data[0]->jenis_kelamin,
            'tgllahir' => $data[0]->tgl_lahir,
            'alamat' => $data[0]->alamat,
            'kota' => $data[0]->kota,
            'kodepos' => '-',
            'prov' => $data[0]->kode_prov,
            'kab' => $data[0]->kode_kab,
            'kec' => $data[0]->kode_kec,
            'des' => $data[0]->kode_des,
        ];
        if ($data[0]->status == 1) {
            $data = [
                'kode' => 500,
                'message' => 'Pasien sudah memiliki kode satu sehat'
            ];
            echo json_encode($data);
            die;
        }
        $v = new Satusehat_model();
        $p = $v->createPatientByNIK($datasatusehat);
        // dd($p);
        $id_satu_sehat = 0;
        $status_satu_sehat = 0;
        if ($p['code'] == 200) {
            $id_satu_sehat = $p['data'];
            $status_satu_sehat = 1;
        } else {
            $data = [
                'kode' => 500,
                'message' => 'gagal kirim data satu sehat ... '
            ];
            echo json_encode($data);
            die;
        }
        $datapasien = [
            'ihs_code' => $id_satu_sehat,
            'status' => $status_satu_sehat,
        ];
        ihs_mt_pasien::whereRaw('no_rm = ?', array($rm))->update($datapasien);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function kirimKunjunganSatuSehat(Request $request)
    {
        $v = new Satusehat_model();
        $id = $request->idk;
        $data_kunjungan1 = db::select('select * from ihs_ts_kunjungan where id = ?', [$id]);
        $pasien = db::select('select * from ihs_mt_pasien where no_rm = ?', [$data_kunjungan1[0]->no_rm]);
        // dd($data_kunjungan1[0]->no_rm);
        $idpasien = $pasien[0]->ihs_code;
        if ($idpasien == 0) {
            $data = [
                'kode' => 500,
                'message' => 'Pasien belum memiliki id satu sehat ... '
            ];
            echo json_encode($data);
            die;
        }
        $idkunjungan = $id;
        $cek = db::select('select * from ihs_status_enocunter where id_ihs_ts_kunjungan = ?', [$id]);
        if (count($cek) > 0) {
            $id_ihs_monitoring = $cek[0]->id;
        } else {
            $ihs_monitoring = ihs_status_encounter::create(['id_ihs_ts_kunjungan' => $id]);
            $id_ihs_monitoring = $ihs_monitoring->id;
            $cek = db::select('select * from ihs_status_enocunter where id = ?', [$id_ihs_monitoring]);
        }
        if ($data_kunjungan1[0]->status_ihs == 0) {
            $data_create_encounter = [
                'idpasien' => $idpasien,
                'namapasien' => $data_kunjungan1[0]->nama_pasien,
                'iddokter' => $data_kunjungan1[0]->kode_ihs_dokter,
                'namadokter' => $data_kunjungan1[0]->nama_dokter,
                'tglmasuk' => $data_kunjungan1[0]->tgl_masuk,
                'jammasuk' => $data_kunjungan1[0]->jam_masuk,
                'idpoli' => $data_kunjungan1[0]->kode_ihs_poli,
                'namapoli' => $data_kunjungan1[0]->nama_poli,
            ];
            try {
                $p = $v->createEncounter($data_create_encounter);
                $id_satu_sehat = 0;
                $status_satu_sehat = 0;
                if ($p['code'] == 200) {
                    $id_satu_sehat = $p['data']->id;
                    $status_satu_sehat = 1;
                } else {
                    $data = [
                        'kode' => 500,
                        'message' => 'gagal kirim data satu sehat ... '
                    ];
                    echo json_encode($data);
                    die;
                }
                $data_kunjungan = [
                    'ihs_code' => $id_satu_sehat,
                    'status_ihs' => $status_satu_sehat,
                    'kode_ihs_pasien' => $idpasien
                ];
                ihs_ts_kunjungan::whereRaw('id = ?', array($id))->update($data_kunjungan);
                ihs_status_encounter::whereRaw('id = ?', array($id_ihs_monitoring))->update(['id_encounter' => $id_satu_sehat, 'status_kunjungan' => $status_satu_sehat]);
            } catch (\Exception $e) {
                $data = [
                    'kode' => 500,
                    'message' => $e->getMessage(),
                ];
                echo json_encode($data);
                die;
            }
        }
        if ($cek[0]->status_masuk_ruangan == 0) {
            $data_kunjungan1 = db::select('select * from ihs_ts_kunjungan where id = ?', [$id]);
            try {
                $status_satu_sehat_2 = 0;
                $data_update_encounter = [
                    'id_kunjungan_ihs' => $data_kunjungan1[0]->ihs_code,
                    'idpasien' => $idpasien,
                    'namapasien' => $data_kunjungan1[0]->nama_pasien,
                    'iddokter' => $data_kunjungan1[0]->kode_ihs_dokter,
                    'namadokter' => $data_kunjungan1[0]->nama_dokter,
                    'tglmasuk' => $data_kunjungan1[0]->tgl_masuk,
                    'jammasuk' => $data_kunjungan1[0]->jam_masuk,
                    'jam_panggil' => $data_kunjungan1[0]->jam_panggil,
                    'idpoli' => $data_kunjungan1[0]->kode_ihs_poli,
                    'namapoli' => $data_kunjungan1[0]->nama_poli,
                ];
                $p2 = $v->updateEncounter($data_update_encounter);
                if ($p2['code'] == 200) {
                    $status_satu_sehat_2 = 1;
                }
                ihs_status_encounter::whereRaw('id = ?', array($id_ihs_monitoring))->update(['status_masuk_ruangan' => $status_satu_sehat_2]);
            } catch (\Exception $e) {
            }
        }
        if ($cek[0]->status_anamnesis == 0) {
            $data_kunjungan1 = db::select('select * from ihs_ts_kunjungan where id = ?', [$id]);
            try {
                $status_satu_sehat_3 = 0;
                $data_anamnesa = [
                    'id_kunjungan_ihs' => $data_kunjungan1[0]->ihs_code,
                    'idpasien' => $idpasien,
                    'namapasien' => $data_kunjungan1[0]->nama_pasien,
                    'iddokter' => $data_kunjungan1[0]->kode_ihs_dokter,
                    'namadokter' => $data_kunjungan1[0]->nama_dokter,
                    'tglmasuk' => $data_kunjungan1[0]->tgl_masuk,
                    'jammasuk' => $data_kunjungan1[0]->jam_panggil,
                    'idpoli' => $data_kunjungan1[0]->kode_ihs_poli,
                    'namapoli' => $data_kunjungan1[0]->nama_poli,
                    'keluhan' => $data_kunjungan1[0]->keluhan_pasien,
                ];
                $p3 = $v->anamnesisKeluhanUtama($data_anamnesa);
                if ($p3['code'] == 200) {
                    $status_satu_sehat_3 = 1;
                    ihs_status_encounter::whereRaw('id = ?', array($id_ihs_monitoring))->update(['status_anamnesis' => $status_satu_sehat_3]);
                }
            } catch (\Exception $e) {
            }
        }
        if ($cek[0]->status_diagnosis == 0) {
            $data_kunjungan1 = db::select('select * from ihs_ts_kunjungan where id = ?', [$id]);
            try {
                $status_satu_sehat_4 = 0;
                $data_diganosa = [
                    'id_kunjungan_ihs' => $data_kunjungan1[0]->ihs_code,
                    'idpasien' => $idpasien,
                    'namapasien' => $data_kunjungan1[0]->nama_pasien,
                    'iddokter' => $data_kunjungan1[0]->kode_ihs_dokter,
                    'namadokter' => $data_kunjungan1[0]->nama_dokter,
                    'tglmasuk' => $data_kunjungan1[0]->tgl_masuk,
                    'jammasuk' => $data_kunjungan1[0]->jam_panggil,
                    'idpoli' => $data_kunjungan1[0]->kode_ihs_poli,
                    'namapoli' => $data_kunjungan1[0]->nama_poli,
                    'keluhan' => $data_kunjungan1[0]->keluhan_pasien,
                    'diagnosa' => $data_kunjungan1[0]->diagnosa_primer,
                    'diagnosadisplay' => $data_kunjungan1[0]->display_diagnosa_primer,
                ];
                $p4 = $v->diagnosaprimer($data_diganosa);
                // dd($data_diganosa);
                $id_diagnosa = 0;
                if ($p4['code'] == 200) {
                    $id_diagnosa = $p4['data']->id;
                    $status_satu_sehat_4 = 1;
                }
                $data_kunjungan_2 = [
                    'ihs_code_diagnosa' => $id_diagnosa,
                ];
                ihs_ts_kunjungan::whereRaw('id = ?', array($id))->update($data_kunjungan_2);
                ihs_status_encounter::whereRaw('id = ?', array($id_ihs_monitoring))->update(['status_diagnosis' => $status_satu_sehat_4, 'ref_diagnosis' => $id_diagnosa]);
            } catch (Exception $e) {
            }
        }
        if ($cek[0]->status_encounter == 0) {
            $data_kunjungan1 = db::select('select * from ihs_ts_kunjungan where id = ?', [$id]);
            try {
                $status_satu_sehat_5 = 0;
                $data_pulang = [
                    'id_kunjungan_ihs' => $data_kunjungan1[0]->ihs_code,
                    'idpasien' => $idpasien,
                    'namapasien' => $data_kunjungan1[0]->nama_pasien,
                    'iddokter' => $data_kunjungan1[0]->kode_ihs_dokter,
                    'namadokter' => $data_kunjungan1[0]->nama_dokter,
                    'tglmasuk' => $data_kunjungan1[0]->tgl_masuk,
                    'jammasuk' => $data_kunjungan1[0]->jam_masuk,
                    'jampanggil' => $data_kunjungan1[0]->jam_panggil,
                    'jam_selesai' => $data_kunjungan1[0]->jam_selesai,
                    'idpoli' => $data_kunjungan1[0]->kode_ihs_poli,
                    'namapoli' => $data_kunjungan1[0]->nama_poli,
                    'keluhan' => $data_kunjungan1[0]->keluhan_pasien,
                    'rencana' => trim($data_kunjungan1[0]->planning),
                    'ihs_code_diagnosa' => $data_kunjungan1[0]->ihs_code_diagnosa,
                    'diagnosa' => $data_kunjungan1[0]->diagnosa_primer,
                    'diagnosadisplay' => $data_kunjungan1[0]->display_diagnosa_primer,
                ];
                // dd($data_pulang);
                $p5 = $v->updatePulang($data_pulang);
                if ($p5['code'] == 200) {
                    $status_satu_sehat_5 = 1;
                    ihs_status_encounter::whereRaw('id = ?', array($id_ihs_monitoring))->update(['status_encounter' => $status_satu_sehat_5]);
                }
            } catch (Exception $e) {
            }
        }
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function kirimdataunitsatusehat(Request $request)
    {
        $namaunit = $request->namaunit;
        $v = new Satusehat_model();
        $p = $v->CreateOrganizationPoli($namaunit);
        try {
            if ($p['code'] == 200) {
                $id = $p['data']->id;
                $dataunit = [
                    'loc_ihs_kode' => $id
                ];
                master_unit::whereRaw('id = ?', array($request->idunit))->update($dataunit);
                $data = [
                    'kode' => 200,
                    'message' => 'Data berhasil dikirim'
                ];
                echo json_encode($data);
            } else {
                $data = [
                    'kode' => 500,
                    'message' => 'Gagal kirim data ...!'
                ];
                echo json_encode($data);
            }
        } catch (\exception $e) {
            $data = [
                'kode' => 500,
                'message' => $e->getMessage()
            ];
            echo json_encode($data);
        }
    }
    public function ambilDataKunjunganIHS(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data = DB::connection('mysql')->select('select *,a.id as idk  from ihs_ts_kunjungan a left outer join ihs_status_enocunter b on a.id = b.id_ihs_ts_kunjungan where a.tgl_masuk between ? and ?', [$awal, $akhir]);
        // dd($data);
        return view('Master.tabel_kunjungan_ihs', compact([
            'data'
        ]));
    }
    public function cariPasienSatusehat(Request $request)
    {
        $ktp = $request->nomorktp;
        $v = new Satusehat_model();
        $p = $v->searchpatienbynik($ktp);
        if ($p['code'] == 200) {
            $id = $p['data']->entry[0]->resource->id;
        } else {
            $id = 0;
        }
        return view('Master.data_pasien_ihs_by_nik', compact([
            'ktp',
            'id'
        ]));
    }
    public function editPasienIHS(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $datapasien = [
            'status' => 1,
            'ihs_code' => $dataSet['idsatusehatpasien']
        ];
        ihs_mt_pasien::whereRaw('no_rm = ?', array($dataSet['rmpasien']))->update($datapasien);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function cariKabupatenByProv(Request $request)
    {
        // dd($request);

        $kodeprov = $request['kodeprovinsi2'];
        $namakabupaten = $request['namakabupaten'];
        // dd($kec);
        if (strlen($namakabupaten) > 2) {
            $result = DB::select("SELECT a.code as idkabupaten
                    ,a.name as nama_kabupaten
                    FROM mt_lokasi_kabupaten_satu_sehat a
                    JOIN mt_lokasi_provinsi_satu_sehat b ON a.`parent_code` = b.`code`
                    WHERE b.code = '$kodeprov' and a.name LIKE '%$namakabupaten%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->nama_kabupaten,
                        'kode' => $row->idkabupaten,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function carikecamatanbykab(Request $request)
    {
        // dd($request);

        $kodekabupaten = $request['kodekabupaten2'];
        $namakecamatan = $request['namakecamatan'];
        // dd($kec);
        if (strlen($namakecamatan) > 2) {
            $result = DB::select("SELECT a.code as idkecamatan
                    ,a.name as nama_kecamatan
                    FROM mt_lokasi_kecamatan_satu_sehat a
                    JOIN mt_lokasi_kabupaten_satu_sehat b ON a.`parent_code` = b.`code`
                    WHERE a.parent_code = '$kodekabupaten' and a.name LIKE '%$namakecamatan%'");
            if (count($result) > 0) {
                foreach ($result as $row)
                    $arr_result[] = array(
                        'label' => $row->nama_kecamatan,
                        'kode' => $row->idkecamatan,
                    );
                echo json_encode($arr_result);
            }
        }
    }
    public function indeMasterTarif()
    {
        $menu = "mastertarif";
        $mt_tarif = db::select('select * from mt_tarif_baru');
        $mt_unit = db::select('select * from mt_unit');
        return view('Master.index_master_tarif', compact([
            'menu',
            'mt_tarif','mt_unit'
        ]));
    }
    public function ambilMaterTarif()
    {
        $tarif = db::select('select *,a.id as idtarif from mt_tarif_baru a left outer join mt_unit b on a.kode_unit = b.kode_unit');
        return view('Master.tb_master_Tarif', compact([
            'tarif'
        ]));
    }
    public function getmasterdesa(request $request)
    {
        $id = $request->kecamatan;
        $v = new Satusehat_model();
        $p = $v->get_desa($id);
        if ($p->status == 200) {
            $arr = $p->data;
            // dd($arr);
            foreach ($arr as $a) {
                $code = $a->code;
                $cek = db::select('select count(code) as jlh from mt_lokasi_desa_satu_sehat where code = ?', [$code]);
                if ($cek[0]->jlh == 0) {
                    $datadesa = [
                        'code' => $a->code,
                        'parent_code' => $a->parent_code,
                        'bps_code' => $a->bps_code,
                        'name' => $a->name
                    ];
                    mt_lokasi_desa_satu_sehat::create($datadesa);
                }
            }
            $data = [
                'kode' => 200,
                'message' => 'sukses'
            ];
            echo json_encode($data);
            die;
        } else {
            $id = 0;
            $data = [
                'kode' => 500,
                'message' => 'error'
            ];
            echo json_encode($data);
            die;
        }
        $id = 0;
        $data = [
            'kode' => 500,
            'message' => 'error'
        ];
        echo json_encode($data);
        die;
    }
}
