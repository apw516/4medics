<?php

namespace App\Http\Controllers;

use App\Models\farmasi_stok_persediaan;
use App\Models\farmasidetailorder;
use App\Models\farmasiheaderorder;
use App\Models\kartustok;
use App\Models\layanan_detail;
use App\Models\layanan_header;
use App\Models\masterbarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FarmasiController extends Controller
{
    public function farmasimasterbarang()
    {
        $menu = 'masterbarang';
        $master_barang = db::select('select * from mt_barang');
        $total = count($master_barang);
        return view('Farmasi.indexmasterbarang', compact([
            'menu',
            'total'
        ]));
    }
    public function farmasiorderresep()
    {
        $menu = 'dataorder';
        $date = $this->get_date();
        return view('Farmasi.indexorderresep', compact([
            'menu',
            'date'
        ]));
    }
    public function ambilformmasterbarang()
    {
        $satuan = db::select('select * from mt_satuan');
        $sediaan = db::select('select * from mt_sediaan');
        return view('Farmasi.form_add_master_barang', compact([
            'satuan',
            'sediaan'
        ]));
    }
    public function liatstokobat(Request $request)
    {
        $id = $request->id;
        $barang = db::select('select * from mt_barang where kode_barang = ?', [$id]);
        $stok = DB::select('select * from ti_kartu_stok where kode_barang = ? and no = (select max(no) from ti_kartu_stok where kode_barang = ?)', [$id, $id]);
        $stok_sediaan = db::select('select * from farmasi_stok_persediaan where kode_barang = ?', [$id]);
        return view('Farmasi.v_stok_obat', compact([
            'stok',
            'barang',
            'stok_sediaan'
        ]));
    }
    public function formeditobat(Request $request)
    {
        $id = $request->id;
        $satuan = db::select('select * from mt_satuan');
        $sediaan = db::select('select * from mt_sediaan');
        $barang = db::select('select * from mt_barang where id = ?', [$id]);
        return view('Farmasi.form_edit_obat', compact([
            'barang',
            'satuan',
            'sediaan'
        ]));
    }
    public function cari_order_resep(Request $request)
    {
        $awal = $request->awal;
        $akhir = $request->akhir;
        $data  = db::select('select * from farmasi_header_order where date(tgl_entry) between ? and ? and status != ?', [$awal, $akhir, 3]);
        return view('Farmasi.tabel_orderan_resep', compact([
            'data'
        ]));
    }
    public function cariObatFarmasi(Request $request)
    {
        $nama = $request->namaobat;
        if (strlen($nama) < 3) {
            $master_barang = db::select('select * from mt_barang where nama_barang LIKE ? ORDER BY id DESC LIMIT 200', ['%' . $nama . '%']);
        } else {
            $master_barang = db::select('select * from mt_barang where nama_barang LIKE ?', ['%' . $nama . '%']);
        }
        return view('Farmasi.tabelobatfarmasi', compact([
            'master_barang'
        ]));
    }
    public function ambilDetailOrderan(Request $request)
    {
        $idheader = $request->idheader;
        $data  = db::select('select *,b.id as id_detail from farmasi_header_order a left outer join farmasi_detail_order b on a.id = b.id_header where a.id =? and b.status = 1', [$idheader]);
        $data2  = db::select('select *,b.id as id_detail from farmasi_header_order a left outer join farmasi_detail_order b on a.id = b.id_header where a.id =? ', [$idheader]);
        return view('Farmasi.detail_orderan', compact([
            'data',
            'idheader',
            'data2'
        ]));
    }
    public function ambilDetailLayanan(Request $request)
    {
        $idheader = $request->idheader;
        $data  = db::select('select *,b.id as id_detail from farmasi_header_order a inner join farmasi_detail_order b on a.id = b.id_header where a.id =?', [$idheader]);
        // dd($data);
        $data2 = db::select('select *,b.id as iddetail,a.id as idheader from ts_layanan_header a inner join ts_layanan_detail b  on a.id = b.row_id_header
        inner join mt_barang c on b.kode_barang = c.kode_barang
        where a.kode_kunjungan = ? and b.status_layanan_detail != ?', [$data[0]->kode_kunjungan,'CCL']);
        // dd($data2);
        return view('Farmasi.detail_layanan', compact([
            'data',
            'idheader',
            'data2'
        ]));
    }
    public function hitungOrderanFarmasi(Request $request)
    {
        $data3 = json_decode($_POST['data'], true);
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'qty') {
                $array_layanan_obat[] = $dataSet3;
            }
        }
        foreach ($array_layanan_obat as $ob) {
            $dataobat = db::select('select * from mt_barang where kode_barang = ?', [$ob['idobat']]);
            $stok_sediaan = db::select('select * from farmasi_stok_persediaan where kode_barang = ? and harga_jual = (select max(harga_jual) from farmasi_stok_persediaan where kode_barang = ?)',[$ob['idobat'],$ob['idobat']]);
            $dataSetobat['iddetail'] = $ob['iddetail'];
            $dataSetobat['namaobat'] = $dataobat[0]->nama_barang;
            $dataSetobat['dosis'] = $ob['dosis'];
            $dataSetobat['sediaan'] = $ob['sediaan'];
            $dataSetobat['aturan_pakai'] = $ob['aturanpakai'];
            $dataSetobat['hargajual'] = $stok_sediaan[0]->harga_jual;
            $dataSetobat['qty'] = $ob['qty'];
            $dataSetobat['total'] = $ob['qty'] * $stok_sediaan[0]->harga_jual;
            $arraynd[] = $dataSetobat;
        }
        return view('Farmasi.hitung_order', compact([
            'arraynd'
        ]));
    }
    public function simpanLayananResep(Request $request)
    {
        $data3 = json_decode($_POST['data'], true);
        $idheader = $request->header;
        foreach ($data3 as $nama3) {
            $index3 = $nama3['name'];
            $value3 = $nama3['value'];
            $dataSet3[$index3] = $value3;
            if ($index3 == 'qty') {
                $array_layanan_obat[] = $dataSet3;
            }
        }
        foreach($array_layanan_obat as $ob){
            $get_stok_last = DB::select('select * from ti_kartu_stok where kode_barang = ? and no = (select max(no) from ti_kartu_stok where kode_barang =?)', [$ob['idobat'], $ob['idobat']]);
            $stok_current = $get_stok_last[0]->stok_current;
            $stok_new = $stok_current - $ob['qty'];
            if($stok_new < 0){
                $back = [
                    'kode' => 500,
                    'message' => 'Stok persediaan'. $ob['namaobat'] .' tidak ada / belum tersimpan !'
                ];
                echo json_encode($back);
                die;
            }
        }
        $dataheader = db::select('select * from farmasi_header_order where id = ?', [$idheader]);
        $datakunjungan = db::select('select * from ts_kunjungan where kode_kunjungan = ?', [$dataheader[0]->kode_kunjungan]);
        $kode_layanan_header =  $this->createLayananheader();
        $datalayananheader = $data_layanan_header = [
            'kode_layanan_header' => $kode_layanan_header,
            'tgl_entry' => $this->get_now(),
            'kode_kunjungan' => $dataheader[0]->kode_kunjungan,
            'kode_unit' => '4008',
            'kode_tipe_transaksi' => '1',
            'pic' => auth()->user()->id,
            'status_layanan' => 1,
            'dok_kirim' => $datakunjungan[0]->kode_paramedis,
            'unit_pengirim' => $dataheader[0]->unit_kirim,
        ];
        $layanan_header = layanan_header::create($data_layanan_header);
        // dd($array_layanan_obat);
        $gt_header = 0;
        foreach ($array_layanan_obat as $ob) {
            $mt_barang = db::select('select * from mt_barang where kode_barang = ?', [$ob['idobat']]);
            $stok_sediaan = db::select('select * from farmasi_stok_persediaan where kode_barang = ? and harga_jual = (select max(harga_jual) from farmasi_stok_persediaan where kode_barang = ?)',[$ob['idobat'],$ob['idobat']]);
            $gt = $ob['qty'] * $stok_sediaan[0]->harga_jual;
            $id_detail = $this->createLayanandetail();
            $data_detail = [
                'id_layanan_detail' =>$id_detail,
                'kode_layanan_header' => $kode_layanan_header,
                'total_tarif' => $stok_sediaan[0]->harga_jual,
                'jumlah_layanan' => $ob['qty'],
                'total_layanan' => $ob['qty'] * $stok_sediaan[0]->harga_jual,
                'grantotal_layanan' => $ob['qty'] * $stok_sediaan[0]->harga_jual,
                'tgl_layanan_detail' => $this->get_now(),
                'status_layanan_detail' => 'OPN',
                'kode_barang' => $ob['idobat'],
                'aturan_pakai' => $ob['aturanpakai'],
                'satuan_barang' => $ob['sediaan'],
                'tagihan_pribadi' => $ob['qty'] * $stok_sediaan[0]->harga_jual,
                'row_id_header' => $layanan_header->id,
                'keterangan01' => $ob['namaobat'],
            ];
            $gt_header = $gt_header + $gt;
            layanan_detail::create($data_detail);
            farmasidetailorder::whereRaw('id = ?', $ob['iddetail'])->update(['status' => '2','id_layanan_detail' => $id_detail]);
            $get_stok_last = DB::select('select * from ti_kartu_stok where kode_barang = ? and no = (select max(no) from ti_kartu_stok where kode_barang =?)', [$ob['idobat'], $ob['idobat']]);
            $data_ti_kartu_stok = [
                'no_dokumen' => $kode_layanan_header,
                'no_dokumen_detail' => $id_detail,
                'tgl_stok' => $this->get_now(),
                'kode_unit' => '4008',
                'kode_barang' => $ob['idobat'],
                'stok_last' => $get_stok_last[0]->stok_current,
                'stok_out' => $ob['qty'],
                'stok_current' => $get_stok_last[0]->stok_current - $ob['qty'],
                'harga_beli' => $get_stok_last[0]->harga_beli,
            ];
            kartustok::create($data_ti_kartu_stok);
            $stok_p = -1;
            $no = 0;
            while ($stok_p < 0) {
                // $STOK_SEDIAAN = db::select('SELECT * FROM ti_stok_persediaan_farmasi WHERE kode_barang = ?  AND ed IN (SELECT MIN(ed) FROM ti_stok_persediaan_farmasi where stok_current > ? AND kode_barang = ?)', [$a['kodelayanan'], 0, $a['kodelayanan']]);


                $get_stok_sediaan = db::select('SELECT * FROM farmasi_stok_persediaan WHERE kode_barang = ?  AND ed IN (SELECT MIN(ed) FROM farmasi_stok_persediaan where stok > ? AND kode_barang = ?)', [$ob['idobat'], 0, $ob['idobat']]);

                // $get_stok_sediaan = DB::select('select * from farmasi_stok_persediaan where kode_barang = ? and id = (select min(id) from farmasi_stok_persediaan where kode_barang = ? and stok > 0)', [$ob['idobat'], $ob['idobat']]);
                if (count($get_stok_sediaan) > 0) {
                    // ti_kartu_stok::create($kartu_stok);
                    $stok_current_sediaan = $get_stok_sediaan[0]->stok;
                    if ($no == 0) {
                        $stok_out = $stok_current_sediaan - $ob['qty'];
                    } else {
                        $stok_out = $stok_current_sediaan + $stok_p;
                    }
                    if ($stok_out < 0) {
                        $stok_sediaan = 0;
                        $stok_log = $stok_current_sediaan;
                    } else {
                        $stok_sediaan = $stok_out;
                        $stok_log = $stok_current_sediaan - $stok_out;
                    }
                    $data = [
                        'stok' => $stok_sediaan,
                    ];
                    farmasi_stok_persediaan::where('id', $get_stok_sediaan[0]->id)->update($data);
                    $stok_p = $stok_out;
                    $no++;
                } else {
                    // ts_layanan_header_order::where('id', $id_header)
                    //     ->update(['status_layanan' => 4]);
                    $back = [
                        'kode' => 500,
                        'message' => 'Stok persediaan tidak ada / belum tersimpan !'
                    ];
                    echo json_encode($back);
                    die;
                }
            }
        }
        layanan_header::whereRaw('id = ?', $layanan_header->id)->update(['total_layanan' => $gt_header, 'tagihan_pribadi' => $gt_header]);
        farmasiheaderorder::whereRaw('id = ?', $idheader)->update(['status' => '2', 'id_layanan_header' => $layanan_header->id]);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function createLayananheader()
    {
        $q = DB::connection('mysql2')->select('SELECT id,kode_layanan_header,RIGHT(kode_layanan_header,6) AS kd_max  FROM ts_layanan_header
        WHERE DATE(tgl_entry) = CURDATE()
        ORDER BY id DESC
        LIMIT 1');
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'FAR' . date('ymd') . $kd;
    }
    public function createLayanandetail()
    {
        $q = DB::connection('mysql2')->select('SELECT id,id_layanan_detail,RIGHT(id_layanan_detail,6) AS kd_max  FROM ts_layanan_detail
        WHERE DATE(tgl_layanan_detail) = CURDATE()
        ORDER BY id DESC
        LIMIT 1');
        $kd = "";
        if (count($q) > 0) {
            foreach ($q as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'DET' . date('ymd') . $kd;
    }
    public function ambilformaddstok(Request $request)
    {
        $barang = db::select('select * from mt_barang a inner join mt_satuan b on a.satuan = b.kode_satuan where a.id = ? ', [$request->id]);
        return view('Farmasi.form_add_stok_barang', compact([
            'barang'
        ]));
    }
    public function ambilmasterbarang(Request $request)
    {
        $nama = $request->nama;
        if (strlen($nama) < 3) {
            $master_barang = db::select('select * from mt_barang where nama_barang LIKE ? ORDER BY id DESC LIMIT 200', ['%' . $nama . '%']);
        } else {
            $master_barang = db::select('select * from mt_barang where nama_barang LIKE ?', ['%' . $nama . '%']);
        }
        return view('Farmasi.tabel_master_barang', compact([
            'master_barang'
        ]));
    }
    public function simpanmasterbarang(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $kode_barang = $this->GET_BARANG();
        $data_barang = [
            'kode_tipe' => '1',
            'kode_barang' => $kode_barang,
            'nama_barang' => $dataSet['namabarang'],
            'nama_generik' => $dataSet['namagenerik'],
            'dosis' => $dataSet['dosis'],
            'aturan_pakai' => $dataSet['aturanpakai'],
            'satuan_besar' => $dataSet['satuanbesar'],
            'satuan' => $dataSet['satuansedang'],
            'sediaan' => $dataSet['sediaan'],
        ];
        masterbarang::create($data_barang);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function updatestokbarang(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        $id = $dataSet['idbarang'];
        $data_barang = [
            'kode_tipe' => '1',
            'nama_barang' => $dataSet['namabarang'],
            'nama_generik' => $dataSet['namagenerik'],
            'dosis' => $dataSet['dosis'],
            'aturan_pakai' => $dataSet['aturanpakai'],
            'satuan_besar' => $dataSet['satuanbesar'],
            'satuan' => $dataSet['satuansedang'],
            'sediaan' => $dataSet['sediaan'],
        ];
        masterbarang::whereRaw('id = ?', $id)->update($data_barang);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function simpanstokbarang(Request $request)
    {
        $data = json_decode($_POST['data'], true);
        foreach ($data as $nama) {
            $index =  $nama['name'];
            $value =  $nama['value'];
            $dataSet[$index] = $value;
        }
        if ($dataSet['satuanmasuk'] == 1) {
            $jumlah = $dataSet['jumlahstok'];
            $rasio = $dataSet['rasiokecil'];
            $stok = $rasio * $jumlah;
        } elseif ($dataSet['satuanmasuk'] == 2) {
            $jumlah = $dataSet['jumlahstok'];
            $rasio = $dataSet['rasiokecil'];
            $stok = $rasio * $jumlah;
        } elseif ($dataSet['satuanmasuk'] == 3) {
            $stok = $dataSet['jumlahstok'];
        }
        $dbarang = DB::select('select * from ti_kartu_stok where kode_barang = ? and no = (select max(no) from ti_kartu_stok where kode_barang = ?)', [$dataSet['kodebarang'], $dataSet['kodebarang']]);
        if (count($dbarang) > 0) {
            $stok_last = $dbarang[0]->stok_current;
            $stok_current = $stok + $stok_last;
            $stok_in = $stok;
        } else {
            $stok_last = 0;
            $stok_current = $stok;
            $stok_in = $stok;
        }
        $harga_beli = $dataSet['hargabeli'] / $stok;
        $data_stok = [
            'no_dokumen' => '',
            'tgl_stok' => $this->get_now(),
            'kode_unit' => '4008',
            'kode_barang' => $dataSet['kodebarang'],
            'stok_last' => $stok_last,
            'stok_in' => $stok_in,
            'stok_out' => 0,
            'stok_current' => $stok_current,
            'harga_beli' => $harga_beli,
        ];
        $persenjual = $dataSet['hargajual'];
        $prof = $harga_beli * $persenjual / 100;
        $harga_jual = $harga_beli + $prof;
        kartustok::create($data_stok);
        $cek_sediaan = db::select('select * from farmasi_stok_persediaan where kode_barang = ? and ed = ? and harga_beli = ?', [$dataSet['kodebarang'], $dataSet['ed'], $harga_beli]);
        $mt_barang = db::select('select * from mt_barang where kode_barang = ?', [$dataSet['kodebarang']]);
        if (count($cek_sediaan) > 0) {
            $datasediaan = [
                'stok' => $stok_current + $cek_sediaan[0]->stok,
            ];
            farmasi_stok_persediaan::whereRaw('id = ?', $cek_sediaan[0]->id)->update($datasediaan);
        } else {
            $datasediaan = [
                'kode_barang' => $dataSet['kodebarang'],
                'nama_barang' => $mt_barang[0]->nama_barang,
                'ed' => $dataSet['ed'],
                'harga_beli' => $harga_beli,
                'harga_jual' => $harga_jual,
                'harga_jual_persen' => $persenjual,
                'tgl_entry' => $this->get_now(),
                'stok' => $stok,
            ];
            farmasi_stok_persediaan::create($datasediaan);
        }
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
    public function GET_BARANG()
    {
        $y = DB::select('SELECT MAX(RIGHT(kode_barang,6)) AS kd_max FROM mt_barang');
        if (count($y) > 0) {
            foreach ($y as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%06s", $tmp);
            }
        } else {
            $kd = "000001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return 'B' . $kd;
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
    public function batalLayananResep(Request $request)
    {
        $iddetail = $request->iddetail;
        $idheader = $request->idheader;
        $detail = db::select('select * from ts_layanan_detail where id = ?',[$iddetail]);
        if($detail[0]->status_layanan_detail == 'CCL'){
            $data = [
                'kode' => 500,
                'message' => 'Gagal, Layanan sudah diretur sebelumnya'
            ];
            echo json_encode($data);
            die;
        }
        $detail_new = [
            'jumlah_retur' => $detail[0]->jumlah_layanan,
            'status_layanan_detail' => 'CCL',
            'grantotal_layanan' => 0,
            'tagihan_pribadi' => 0,
        ];
        layanan_detail::whereRaw('id = ?', $iddetail)->update($detail_new);
        $header = db::select('select * from ts_layanan_header where id = ?',[$idheader]);
        $detail2 = db::select('select * from ts_layanan_detail where row_id_header = ? and status_layanan_detail = ?',[$idheader,'OPN']);
        $total_layanan_header = $header[0]->total_layanan;
        $new_total_layanan_header = $total_layanan_header - $detail[0]->grantotal_layanan;
        if($new_total_layanan_header < 0){
            $new_total_layanan_header = 0;
        }
        if(count($detail2) > 0){
            $status_header = 1;
            $status_retur = 'OPN';
        }else{
            $status_header = 3;
            $status_retur = 'CLS';
        }
        $data_header = [
            'status_layanan' => $status_header,
            'status_retur' => $status_retur,
            'total_layanan' => $new_total_layanan_header,
            'tagihan_pribadi' => $new_total_layanan_header
        ];
        layanan_header::whereRaw('id = ?',$idheader)->update($data_header);
        $kodeobat = $detail[0]->kode_barang;
        $kodeheader = $detail[0]->kode_layanan_header;
        $kodedetail = $detail[0]->id_layanan_detail;
        $get_stok_last = DB::select('select * from ti_kartu_stok where kode_barang = ? and no = (select max(no) from ti_kartu_stok where kode_barang =?)', [$kodeobat, $kodeobat]);
        $data_ti_kartu_stok = [
            'no_dokumen' => $kodeheader,
            'no_dokumen_detail' => $kodedetail,
            'tgl_stok' => $this->get_now(),
            'kode_unit' => '4008',
            'kode_barang' => $kodeobat,
            'stok_last' => $get_stok_last[0]->stok_current,
            'stok_current' => $get_stok_last[0]->stok_current + $detail[0]->jumlah_layanan,
            'stok_in' => $detail[0]->jumlah_layanan,
            'harga_beli' => $get_stok_last[0]->harga_beli,
        ];
        kartustok::create($data_ti_kartu_stok);
        $last_sediaan = db::select('select * from farmasi_stok_persediaan where kode_barang = ? and id = (select max(id) from farmasi_stok_persediaan where kode_barang = ?)',[$kodeobat,$kodeobat]);
        $sdiaan = [
            'stok' => $last_sediaan[0]->stok + $detail[0]->jumlah_layanan
        ];
        farmasi_stok_persediaan::where('id', $last_sediaan[0]->id)->update($sdiaan);
        farmasidetailorder::whereRaw('id_layanan_detail = ?', $kodedetail)->update(['status' => '1']);
        $data = [
            'kode' => 200,
            'message' => 'sukses'
        ];
        echo json_encode($data);
    }
}
