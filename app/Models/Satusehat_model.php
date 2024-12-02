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
    // public $urlloginpelayanan = 'https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1/';
    public $urlloginpelayanan = 'https://api-satusehat.kemkes.go.id/oauth2/v1/';
    // public $urlpelayanan = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/';
    public $urlpelayanan = 'https://api-satusehat.kemkes.go.id/fhir-r4/v1/';
    public $urlauthmaster = 'https://api-satusehat.kemkes.go.id/oauth2/v1/';
    public $urlmaster = 'https://api-satusehat-stg.dto.kemkes.go.id/masterdata/v1/';
    public $idorg = '100158569';
    // public $idorg = 'b162afd3-892d-4e8f-a018-d941317e52b0';
    public $client_id = 'oqkA3u1y5Bz7vwdjHZL7GWztPtwmCPg1Cbof6zRkHtSDvTN2';
    // public $client_id = 'bgVWzHZKRvTPpJZWGlxHEQX1K7g0aoPGQmxmWsegn889dTjF';
    public $client_secret = 'kJbCI2FlY60IqSsDov7EeQyZAbRKWBfGNg38qI9WhtvtfU8aoN0fhe3XHAXq3pfG';
    // public $client_secret = 'enO5BG6zTdcSOnlT68Cx1FMSjoSeGiJZrcOkh2Iqb6ylHZjbeUvFJFY1JmzWgJQT';
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
    public function  CreateOrganizationUKP($data)
    {
        $arrayVar = [
            "resourceType" => "Organization",
            "active" => true,
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "http://sys-ids.kemkes.go.id/organization/$this->idorg",
                    "value" => "SS-UKP",
                ],
            ],
            "type" => [
                [
                    "coding" => [
                        [
                            "system" =>
                            "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code" => "team",
                            "display" => "Organizational team",
                        ],
                    ],
                ],
            ],
            "name" => "$data[namaorg]",
            "telecom" => [
                ["system" => "phone", "value" => "$data[notelporg]", "use" => "work"],
                [
                    "system" => "email",
                    "value" => "$data[email]",
                    "use" => "work",
                ],
                ["system" => "url", "value" => "dto.kemkes.go.id", "use" => "work"],
            ],
            "address" => [
                [
                    "use" => "work",
                    "type" => "both",
                    "line" => [
                        "$data[alamat]",
                    ],
                    "city" => "$data[kota]",
                    "postalCode" => "12950",
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" =>
                            "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                ["url" => "province", "valueCode" => "$data[kodeprovinsiukp]"],
                                ["url" => "city", "valueCode" => "$data[kodekabupatenukp]"],
                                ["url" => "district", "valueCode" => "$data[kodekecamatanukp]"],
                                ["url" => "village", "valueCode" => "$data[kodedesaukp]"],
                            ],
                        ],
                    ],
                ],
            ],
            "partOf" => [
                "reference" => "Organization/$this->idorg",
                "display" => "$data[displayorg]",
            ],
        ];
        $client = new Client();
        $url = $this->urlpelayanan . 'Organization';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'data' => $response,
                'id' => $response->id,
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
    public function  CreateOrganizationPoli($data)
    {
        $arrayVar = [
            "resourceType" => "Location",
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/location/$this->idorg",
                    "value" => "SS-UKP-POLI-ROOM"
                ]
            ],
            "status" => "active",
            "name" => "$data",
            "description" => "$data",
            "mode" => "instance",
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => "-",
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => "-",
                    "use" => "work"
                ],
                [
                    "system" => "url",
                    "value" => "-",
                    "use" => "work"
                ]
            ],
            "physicalType" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/location-physical-type",
                        "code" => "ro",
                        "display" => "Room"
                    ]
                ]
            ],
            "position" => [
                "longitude" => 0,
                "latitude" => 0,
                "altitude" => 0
            ],
            "managingOrganization" => [
                "reference" => "Organization/$this->idorg"
            ]
        ];
        $client = new Client();
        $url = $this->urlpelayanan . 'Location';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'data' => $response,
                'id' => $response->id,
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
    public function  CreateOrganizationKoord($data, $data_org2)
    {
        $arrayVar = [
            "resourceType" => "Organization",
            "active" => true,
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "http://sys-ids.kemkes.go.id/organization/$this->idorg",
                    "value" => "SS-UKP-POLI"
                ]
            ],
            "type" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/organization-type",
                            "code" => "team",
                            "display" => "Organizational team"
                        ]
                    ]
                ]
            ],
            "name" => "$data[namalengkap]",
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => "$data[notelp]",
                    "use" => "work"
                ],
                [
                    "system" => "email",
                    "value" => "$data[email]",
                    "use" => "work"
                ],
                [
                    "system" => "url",
                    "value" => "",
                    "use" => "work"
                ]
            ],
            "address" => [
                [
                    "use" => "work",
                    "type" => "both",
                    "line" => [
                        "$data[alamatjalan]"
                    ],
                    "city" => "$data[alamatkota]",
                    "postalCode" => "$data[kodepos]",
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                [
                                    "url" => "province",
                                    "valueCode" => "$data[kodeprovinsiorg]"
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" => "$data[kodekabupatenorg]"
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" => "$data[kodekecamatanorg]"
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" => "$data[kodedesaorg]"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "partOf" => [
                "reference" => "Organization/$data_org2[kode]",
                "display" => "$data_org2[display]"
            ]
        ];
        // dd($arrayVar);
        $client = new Client();
        $url = $this->urlpelayanan . 'Organization';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'data' => $response,
                'id' => $response->id,
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
        $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Organization?partof=' . $id;
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
        $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Location?organization=' . $ID;
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
    public function searchpatienbynik($ID)
    {
        $client = new Client();
        // $url = 'https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Patient?identifier=https://fhir.kemkes.go.id/id/nik|'.$ID;
            $url = $this->urlpelayanan.'Patient?identifier=https://fhir.kemkes.go.id/id/nik|'.$ID;
        try {
            $response = $client->request('GET', $url, [
                'headers' => $this->generate_token_satu_sehat(),
            ]);
            $response = json_decode($response->getBody());
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
    public function createPatientByNIK($DATA)
    {
        $arrayVar = [
            "resourceType" => "Patient",
            "meta" => [
                "profile" => [
                    "https://fhir.kemkes.go.id/r4/StructureDefinition/Patient"
                ]
            ],
            "identifier" => [
                [
                    "use" => "official",
                    "system" => "https://fhir.kemkes.go.id/id/nik",
                    "value" => "$DATA[nik]"
                ]
            ],
            "active" => true,
            "name" => [
                [
                    "use" => "official",
                    "text" => "$DATA[namapasien]"
                ]
            ],
            "telecom" => [
                [
                    "system" => "phone",
                    "value" => "-",
                    "use" => "mobile"
                ],
                [
                    "system" => "phone",
                    "value" => "-",
                    "use" => "home"
                ],
                [
                    "system" => "email",
                    "value" => "-",
                    "use" => "home"
                ]
            ],
            "gender" => "$DATA[jeniskelamin]",
            "birthDate" => "$DATA[tgllahir]",
            "deceasedBoolean" => false,
            "address" => [
                [
                    "use" => "home",
                    "line" => [
                        "$DATA[alamat]"
                    ],
                    "city" => "$DATA[kota]",
                    "postalCode" => "-",
                    "country" => "ID",
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/administrativeCode",
                            "extension" => [
                                [
                                    "url" => "province",
                                    "valueCode" => "$DATA[prov]"
                                ],
                                [
                                    "url" => "city",
                                    "valueCode" => "$DATA[kab]"
                                ],
                                [
                                    "url" => "district",
                                    "valueCode" => "$DATA[kec]"
                                ],
                                [
                                    "url" => "village",
                                    "valueCode" => "$DATA[des]"
                                ],
                                [
                                    "url" => "rt",
                                    "valueCode" => "-"
                                ],
                                [
                                    "url" => "rw",
                                    "valueCode" => "-"
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "maritalStatus" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/v3-MaritalStatus",
                        "code" => "-",
                        "display" => "-"
                    ]
                ],
                "text" => "-"
            ],
            "multipleBirthInteger" => 0,
            "contact" => [
                [
                    "relationship" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/v2-0131",
                                    "code" => "C"
                                ]
                            ]
                        ]
                    ],
                    "name" => [
                        "use" => "official",
                        "text" => "-"
                    ],
                    "telecom" => [
                        [
                            "system" => "phone",
                            "value" => "-",
                            "use" => "mobile"
                        ]
                    ]
                ]
            ],
            "communication" => [
                [
                    "language" => [
                        "coding" => [
                            [
                                "system" => "urn:ietf:bcp:47",
                                "code" => "id-ID",
                                "display" => "Indonesian"
                            ]
                        ],
                        "text" => "Indonesian"
                    ],
                    "preferred" => true
                ]
            ],
            "extension" => [
                [
                    "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/birthPlace",
                    "valueAddress" => [
                        "city" => "-",
                        "country" => "ID"
                    ]
                ],
                [
                    "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/citizenshipStatus",
                    "valueCode" => "WNI"
                ]
            ]
        ];
        // dd($arrayVar);
        $client = new Client();
        $url = $this->urlpelayanan . 'Patient';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar,
            ]);
            $response = json_decode($response->getBody());
            $response = [
                'code' => 200,
                'data' => $response->data->patient_id,
                'id' => $response->success,
            ];
            return $response;
        } catch (RequestException  $e) {
            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() == '400') {
                    $response = $client->request('POST', $url, [
                        'headers' => $this->generate_token_satu_sehat(),
                        'json' => $arrayVar,
                        'http_errors' => false
                    ]);
                    $response = json_decode($response->getBody());
                    dd($response);
                    try {
                        if (empty($response->data)) {
                            $response = [
                                'code' => 200,
                                'data' => $response->data->resourceId,
                            ];
                        } else {
                            $response = [
                                'code' => 500,
                                'data' => 'ERROR',
                            ];
                        }
                    } catch (RequestException  $e) {
                        $response = [
                            'code' => 500,
                            'data' => 'ERROR',
                        ];
                    }
                    return $response;
                }
            }
            // $response = $e;
            $response = [
                'code' => $e->getCode(),
                'status' => $e->getMessage(),
            ];
            return $response;
        }
    }
    public function createEncounter($DATA)
    {
        $arrayVar = [
            "resourceType" => "Encounter",
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/encounter/$this->idorg",
                    "value" => ""
                ]
            ],
            "status" => "arrived",
            "class" => [
                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code" => "AMB",
                "display" => "ambulatory"
            ],
            "subject" => [
                "reference" => "Patient/$DATA[idpasien]",
                "display" => "$DATA[namapasien]"
            ],
            "participant" => [
                [
                    "type" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code" => "ATND",
                                    "display" => "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual" => [
                        "reference" => "Practitioner/$DATA[iddokter]",
                        "display" => "$DATA[namadokter]"
                    ]
                ]
            ],
            "period" => [
                "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00"
            ],
            "location" => [
                [
                    "location" => [
                        "reference" => "Location/$DATA[idpoli]",
                        "display" => "$DATA[namapoli]"
                    ],
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00"
                    ],
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
                            "extension" => [
                                [
                                    "url" => "value",
                                    "valueCodeableConcept" => [
                                        "coding" => [
                                            [
                                                "system" => "http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient",
                                                "code" => "reguler",
                                                "display" => "Kelas Reguler"
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    "url" => "upgradeClassIndicator",
                                    "valueCodeableConcept" => [
                                        "coding" => [
                                            [
                                                "system" => "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                                                "code" => "kelas-tetap",
                                                "display" => "Kelas Tetap Perawatan"
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "statusHistory" => [
                [
                    "status" => "arrived",
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00"
                    ]
                ]
            ],
            "serviceProvider" => [
                "reference" => "Organization/$this->idorg"
            ]
        ];
        $client = new Client();
        $url = $this->urlpelayanan . 'Encounter';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
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
    public function updateEncounter($DATA)
    {
        $arrayVar = [
            "resourceType" => "Encounter",
            "id" => "$DATA[id_kunjungan_ihs]",
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/encounter/$this->idorg",
                    "value" => ""
                ]
            ],
            "status" => "in-progress",
            "class" => [
                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code" => "AMB",
                "display" => "ambulatory"
            ],
            "subject" => [
                "reference" => "Patient/$DATA[idpasien]",
                "display" => "$DATA[namapasien]"
            ],
            "participant" => [
                [
                    "type" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code" => "ATND",
                                    "display" => "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual" => [
                        "reference" => "Practitioner/$DATA[iddokter]",
                        "display" => "$DATA[namadokter]"
                    ]
                ]
            ],
            "period" => [
                "start" => "2023-08-31T01:00:00+00:00"
            ],
            "location" => [
                [
                    "location" => [
                        "reference" => "Location/$DATA[idpoli]",
                        "display" => "$DATA[namapoli]"
                    ],
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00"
                    ],
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
                            "extension" => [
                                [
                                    "url" => "value",
                                    "valueCodeableConcept" => [
                                        "coding" => [
                                            [
                                                "system" => "http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient",
                                                "code" => "reguler",
                                                "display" => "Kelas Reguler"
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    "url" => "upgradeClassIndicator",
                                    "valueCodeableConcept" => [
                                        "coding" => [
                                            [
                                                "system" => "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                                                "code" => "kelas-tetap",
                                                "display" => "Kelas Tetap Perawatan"
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "statusHistory" => [
                [
                    "status" => "arrived",
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00",
                        "end" => "$DATA[tglmasuk]T$DATA[jam_panggil]+00:00"
                    ]
                ],
                [
                    "status" => "in-progress",
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jam_panggil]+00:00"
                    ]
                ]
            ],
            "serviceProvider" => [
                "reference" => "Organization/$this->idorg"
            ]
        ];
        $client = new Client();
        $url = $this->urlpelayanan . 'Encounter/' . $DATA['id_kunjungan_ihs'];
        try {
            $response = $client->request('PUT', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
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
    public function updatePulang($DATA)
    {

        $arrayVar = [
            "resourceType" => "Encounter",
            "id" => "$DATA[id_kunjungan_ihs]",
            "identifier" => [
                [
                    "system" => "http://sys-ids.kemkes.go.id/encounter/$this->idorg",
                    "value" => ""
                ]
            ],
            "status" => "finished",
            "class" => [
                "system" => "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                "code" => "AMB",
                "display" => "ambulatory"
            ],
            "subject" => [
                "reference" => "Patient/$DATA[idpasien]",
                "display" => "$DATA[namapasien]"
            ],
            "participant" => [
                [
                    "type" => [
                        [
                            "coding" => [
                                [
                                    "system" => "http://terminology.hl7.org/CodeSystem/v3-ParticipationType",
                                    "code" => "ATND",
                                    "display" => "attender"
                                ]
                            ]
                        ]
                    ],
                    "individual" => [
                        "reference" => "Practitioner/$DATA[iddokter]",
                        "display" => "$DATA[namadokter]"
                    ]
                ]
            ],
            "period" => [
                "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00",
                "end" => "$DATA[tglmasuk]T$DATA[jampanggil]+00:00",
            ],
            "location" => [
                [
                    "location" => [
                        "reference" => "Location/$DATA[idpoli]",
                        "display" => "$DATA[namapoli]"
                    ],
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jampanggil]+00:00",
                        "end" => "$DATA[tglmasuk]T$DATA[jam_selesai]+00:00"
                    ],
                    "extension" => [
                        [
                            "url" => "https://fhir.kemkes.go.id/r4/StructureDefinition/ServiceClass",
                            "extension" => [
                                [
                                    "url" => "value",
                                    "valueCodeableConcept" => [
                                        "coding" => [
                                            [
                                                "system" => "http://terminology.kemkes.go.id/CodeSystem/locationServiceClass-Outpatient",
                                                "code" => "reguler",
                                                "display" => "Kelas Reguler"
                                            ]
                                        ]
                                    ]
                                ],
                                [
                                    "url" => "upgradeClassIndicator",
                                    "valueCodeableConcept" => [
                                        "coding" => [
                                            [
                                                "system" => "http://terminology.kemkes.go.id/CodeSystem/locationUpgradeClass",
                                                "code" => "kelas-tetap",
                                                "display" => "Kelas Tetap Perawatan"
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            "diagnosis" => [
                [
                    "condition" => [
                        "reference" => "Condition/$DATA[ihs_code_diagnosa]",
                        "display" => "$DATA[diagnosadisplay]"
                    ],
                    "use" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/diagnosis-role",
                                "code" => "DD",
                                "display" => "Discharge diagnosis"
                            ]
                        ]
                    ],
                    "rank" => 1
                ],
                [
                    "condition" => [
                        "reference" => "Condition/$DATA[ihs_code_diagnosa]",
                        "display" => "$DATA[diagnosadisplay]"
                    ],
                    "use" => [
                        "coding" => [
                            [
                                "system" => "http://terminology.hl7.org/CodeSystem/diagnosis-role",
                                "code" => "DD",
                                "display" => "Discharge diagnosis"
                            ]
                        ]
                    ],
                    "rank" => 2
                ]
            ],
            "statusHistory" => [
                [
                    "status" => "arrived",
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00",
                        "end" => "$DATA[tglmasuk]T$DATA[jampanggil]+00:00"
                    ]
                ],
                [
                    "status" => "in-progress",
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jampanggil]+00:00",
                        "end" => "$DATA[tglmasuk]T$DATA[jam_selesai]+00:00"
                    ]
                ],
                [
                    "status" => "finished",
                    "period" => [
                        "start" => "$DATA[tglmasuk]T$DATA[jam_selesai]+00:00",
                        "end" => "$DATA[tglmasuk]T$DATA[jam_selesai]+00:00"
                    ]
                ]
            ],
            "hospitalization" => [
                "dischargeDisposition" => [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/discharge-disposition",
                            "code" => "home",
                            "display" => "Home"
                        ]
                    ],
                    "text" => "$DATA[rencana]"
                ]
            ],
            "serviceProvider" => [
                "reference" => "Organization/$this->idorg"
            ]
        ];
        // dd($arrayVar);
        $client = new Client();
        $url = $this->urlpelayanan . 'Encounter/' . $DATA['id_kunjungan_ihs'];
        try {
            $response = $client->request('PUT', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
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
    public function anamnesisKeluhanUtama($DATA)
    {
        $arrayVar = [
            "resourceType" => "Condition",
            "clinicalStatus" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code" => "active",
                        "display" => "Active"
                    ]
                ]
            ],
            "category" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code" => "problem-list-item",
                            "display" => "Problem List Item"
                        ]
                    ]
                ]
            ],
            "code" => [
                "coding" => [
                    [
                        "system" => "http://snomed.info/sct",
                        "code" => "64572001",
                        "display" => "disease"
                    ]
                ]
            ],
            "subject" => [
                "reference" => "Patient/$DATA[idpasien]",
                "display" => "$DATA[namapasien]"
            ],
            "encounter" => [
                "reference" => "Encounter/$DATA[id_kunjungan_ihs]"
            ],
            "onsetDateTime" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00",
            "recordedDate" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00",
            "recorder" => [
                "reference" => "Practitioner/$DATA[iddokter]",
                "display" => "$DATA[namadokter]"
            ],
            "note" => [
                [
                    "text" => "$DATA[keluhan]"
                ]
            ]
        ];
        // dd($arrayVar);
        $client = new Client();
        $url = $this->urlpelayanan . 'Condition';
        try {
            $response = $client->request('post', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
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
    public function diagnosaprimer($DATA) {
        $arrayVar = [
            "resourceType" => "Condition",
            "clinicalStatus" => [
                "coding" => [
                    [
                        "system" => "http://terminology.hl7.org/CodeSystem/condition-clinical",
                        "code" => "active",
                        "display" => "Active"
                    ]
                ]
                    ],
            "category" => [
                [
                    "coding" => [
                        [
                            "system" => "http://terminology.hl7.org/CodeSystem/condition-category",
                            "code" => "encounter-diagnosis",
                            "display" => "Encounter Diagnosis"
                        ]
                    ]
                ]
            ],
            "code" => [
                "coding" => [
                    [
                        "system" => "http://hl7.org/fhir/sid/icd-10",
                        "code" => "$DATA[diagnosa]",
                        "display" => "$DATA[diagnosadisplay]"
                    ]
                ]
                    ],
            "subject" => [
                "reference" => "Patient/$DATA[idpasien]",
                "display" => "$DATA[namapasien]"
            ],
            "encounter" => [
                "reference" => "Encounter/$DATA[id_kunjungan_ihs]"
            ],
            "onsetDateTime" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00",
            "recordedDate" => "$DATA[tglmasuk]T$DATA[jammasuk]+00:00"
        ];
        $client = new Client();
        $url = $this->urlpelayanan . 'Condition';
        try {
            $response = $client->request('POST', $url, [
                'headers' => $this->generate_token_satu_sehat(),
                'json' => $arrayVar
            ]);
            $response = json_decode($response->getBody());
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
