<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class bridging_ris extends Model
{
    public $baseUrl = 'http://192.168.10.22/ris/public/api/';
    public function saveorder()
    {
        $arr = ['2','2'];
        $data = [
            'id_pasien' => '490971',
            'norm' => '01002377',
            'nama' => 'test',
            'acc_number' => 'CR240710-117577',
            'id_dokter' => '518',
            'tgl_pemeriksaan' => '2024-01-01',
            'idruangan' => '2',
            'idasuransi' => '7',
            'urgensi' => 'cito'
        ];
        // dd($data);
        $client = new Client();
        $url = $this->baseUrl . 'order/save';
        // $signature = $this->signature();
        // dd($signature);
        $response = $client->request('post', $url, [
            'allow_redirects' => true,
            'timeout' => 5,
            'paramas' => $data
        ]);
        $response = json_decode($response->getBody());
        dd($response);
        if ($response->metaData->code == 200) {
            $decrypt = $this->stringDecrypt($signature['decrypt_key'], $response->response);
            $response->response = json_decode($decrypt);
        }
        return $response;
    }
}
