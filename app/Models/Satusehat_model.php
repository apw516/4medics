<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class Satusehat_model extends Model
{
    public $urlloginpelayanan = 'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1/';
    public $urlpelayanan = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/';
    public $urlauthmaster = 'https://api-satusehat.kemkes.go.id/oauth2/v1/';
    public $urlmaster = 'https://api-satusehat-stg.dto.kemkes.go.id/masterdata/v1/';

    public $client_id = 'bgVWzHZKRvTPpJZWGlxHEQX1K7g0aoPGQmxmWsegn889dTjF';
    public $client_secret = 'enO5BG6zTdcSOnlT68Cx1FMSjoSeGiJZrcOkh2Iqb6ylHZjbeUvFJFY1JmzWgJQT';
    public static function header()
    {
        $response = array(
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Connection' => 'keep-alive',
        );
        return $response;
    }
    public function generate_token_master()
    {
        $urlauthmaster = 'https://api-satusehat.kemkes.go.id/oauth2/v1/';
        $data1 = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
        $data = json_encode($data1);
        $client = new Client();
        $data_header = $this->header();
        $url = $this->urlauthmaster . "accesstoken?grant_type=client_credentials";
        try {
            $response = $client->request('POST', $url, [
                'headers' => $data_header,
                'form_params' => $data1,
                'allow_redirects' => true,
                'timeout' => 20
            ]);
            $response = json_decode($response->getBody());
            $token = $response->access_token;
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ];
            return $headers;
        } catch (ClientException) {
            return 'RTO';
        }
    }
    public function generate_token_satu_sehat()
    {
        $data1 = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
        $data = json_encode($data1);
        $client = new Client();
        $data_header = $this->header();
        $url = $this->urlloginpelayanan . "accesstoken?grant_type=client_credentials";
        try {
            $response = $client->request('POST', $url, [
                'headers' => $data_header,
                'form_params' => $data1,
                'allow_redirects' => true,
                'timeout' => 20
            ]);
            $response = json_decode($response->getBody());
            $token = $response->access_token;
            $headers = [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Connection' => 'keep-alive'
            ];
            return $headers;
        } catch (ClientException) {
            return 'RTO';
        }
    }
    public function get_province()
    {
        $client = new Client();
        $url = $this->urlmaster . 'provinces';

        // $data2= json_encode($data);
        $response = $client->request('GET', $url, [
            'headers' => $this->generate_token_master(),
            'body' => ''
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function get_kota_kabupaten($id)
    {
        $client = new Client();
        $url = $this->urlmaster . 'cities?province_codes=' . $id;
        // $data2= json_encode($data);
        $response = $client->request('GET', $url, [
            'headers' => $this->generate_token_master(),
            'body' => ''
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function get_kecamatan($id)
    {
        $client = new Client();
        $url = $this->urlmaster . 'districts?city_codes=' . $id;
        // $data2= json_encode($data);
        $response = $client->request('GET', $url, [
            'headers' => $this->generate_token_master(),
            'body' => ''
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function get_desa($id)
    {
        $client = new Client();
        $url = $this->urlmaster . 'sub-districts?district_codes=' . $id;
        // $data2= json_encode($data);
        $response = $client->request('GET', $url, [
            'headers' => $this->generate_token_master(),
            'body' => ''
        ]);
        $response = json_decode($response->getBody());
        return $response;
    }
    public function post_pasien_baru_nik()
    {
        $namapasien = 'ROBERT';
        $nik = '3209330506444003';
        $notelp = '';
        $nohp = '';
        $email = '';
        $alamat = '';
        $namakota = '';
        $kodeprov = 32;
        $kodekab = 3209;
        $kodekec = 320933;
        $kodedesa = 3209332005;
        $namakeluarga = 'TEST';
        $telpkeluarga = '';
        $kotakeluarga = '';
        $datapasien = [
            "resourceType" => "Patient",
            "meta" => [
                "profile" => [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Patient",
                ],
            ],
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "https://fhir.kemkes.go.id/id/nik",
                    "value" => ".$nik.",
                ],
            ],
            "active" => true,
            "name" => [["use" => "official", "text" => ".$namapasien."]],
            "telecom" => [
                ["system" => "phone", "value" => ".$nohp.", "use" => "mobile"],
                ["system" => "phone", "value" => ".$notelp.", "use" => "home"],
                ["system" => "email", "value" => ".$email.", "use" => "home"],
            ],
            "gender" => "female",
            "birthDate" => "1945-11-17",
            "deceasedBoolean" => false,
            "address" => [
                [
                    "use" => "home",
                    "line" => [
                        ".$alamat.",
                    ],
                    "city" => ".$namakota.",
                    "postalCode" => "",
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" =>
                            "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                ["url" => "province", "valueCode" => "$kodeprov"],
                                ["url" => "city", "valueCode" => "$kodekab"],
                                ["url" => "district", "valueCode" => "$kodekec"],
                                ["url" => "village", "valueCode" => "$kodedesa"],
                                ["url" => "rt", "valueCode" => "2"],
                                ["url" => "rw", "valueCode" => "2"],
                            ],
                        ],
                    ],
                ],
            ],
            "maritalStatus" => [
                "coding" => [
                    [
                        "system" =>
                        "http://terminology.hl7.org/CodeSystem/v3-MaritalStatus",
                        "code" => "M",
                        "display" => "Married",
                    ],
                ],
                "text" => "Married",
            ],
            "multipleBirthInteger" => 0,
            "contact" => [
                [
                    "relationship" => [
                        [
                            "coding" => [
                                [
                                    "system" =>
                                    "http://terminology.hl7.org/CodeSystem/v2-0131",
                                    "code" => "C",
                                ],
                            ],
                        ],
                    ],
                    "name" => ["use" => "official", "text" => "$namakeluarga"],
                    "telecom" => [
                        [
                            "system" => "phone",
                            "value" => "$telpkeluarga",
                            "use" => "mobile",
                        ],
                    ],
                ],
            ],
            "communication" => [
                [
                    "language" => [
                        "coding" => [
                            [
                                "system" => "urn:ietf:bcp:47",
                                "code" => "id-ID",
                                "display" => "Indonesian",
                            ],
                        ],
                        "text" => "Indonesian",
                    ],
                    "preferred" => true,
                ],
            ],
            "extension" => [
                [
                    "url" =>
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/birthPlace",
                    "valueAddress" => ["city" => "$kotakeluarga", "country" => "ID"],
                ],
                [
                    "url" =>
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/citizenshipStatus",
                    "valueCode" => "WNI",
                ],
            ],
        ];
        $client = new Client();
        $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Patient';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $datapasien
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'status' => $response->message,
                'id' => $response->data->patient_id,
            ];
            return $response;
        } catch (ClientException $e) {
            // $response = $e;
            $response = [
                'code' => $e->getCode(),
                'status' => $e->getMessage(),
            ];
            return $response;
        }
    }
    public function create_kunjungan_baru_pasien_rajal(){

    }
    public function organizationByPartOf()
    {
        $client = new Client();
        $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Organization?partof=b162afd3-892d-4e8f-a018-d941317e52b0';
        try {
            $response = $client->request('GET', $url, [
                'headers' => $this->generate_token_satu_sehat(),
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'data' => $response->entry,
            ];
            return $response;
        } catch (ClientException $e) {
            // $response = $e;
            $response = [
                'code' => $e->getCode(),
                'status' => $e->getMessage(),
            ];
            return $response;
        }
    }
    public function organizationByPartOf2($id)
    {
        $client = new Client();
        $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Organization?partof='.$id;
        try {
            $response = $client->request('GET', $url, [
                'headers' => $this->generate_token_satu_sehat(),
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'data' => $response->entry,
            ];
            return $response;
        } catch (ClientException $e) {
            // $response = $e;
            $response = [
                'code' => $e->getCode(),
                'status' => $e->getMessage(),
            ];
            return $response;
        }
    }
    public function locationByOrgID($ID)
    {
        $client = new Client();
        $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Location?organization='.$ID;
        try {
            $response = $client->request('GET', $url, [
                'headers' => $this->generate_token_satu_sehat(),
            ]);
            $response = json_decode($response->getBody());
            dd($response);
            $response = [
                'code' => 200,
                'data' => $response,
            ];
            return $response;
        } catch (ClientException $e) {
            // $response = $e;
            $response = [
                'code' => $e->getCode(),
                'status' => $e->getMessage(),
            ];
            return $response;
        }
    }
}
