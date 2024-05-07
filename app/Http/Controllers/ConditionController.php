<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Satusehat\Integration\FHIR\Condition;
use Satusehat\Integration\OAuth2Client;

class ConditionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kategori = $request->kategori;
        $kode_icd_10 = $request->kode_icd_10;
        $id_pasien = $request->id_pasien;
        $nama_pasien = $request->nama_pasien;
        $id_encounter = $request->id_encounter;
        // $waktu_onset = $request->waktu_onset;
        // $waktu_recorded = $request->waktu_recorded;
        // Condition
        $condition = new Condition;
        $condition->addClinicalStatus(); // active, inactive, resolved. Default bila tidak dideklarasi = active
        $condition->addCategory($kategori); // Diagnosis, Keluhan. Default : Diagnosis
        $condition->addCode($kode_icd_10); // Kode ICD10
        $condition->setSubject( $id_pasien , $nama_pasien); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $condition->setEncounter($id_encounter); // ID SATUSEHAT Encounter
        // $condition->setOnsetDateTime( $waktu_onset); // timestamp onset. Timestamp sekarang
        // $condition->setRecordedDate($waktu_recorded); // timestamp recorded. Timestamp sekarang
        $condition->json();

        [$statusCode, $response] = $condition->post();
        $res = [
            'status' => $statusCode,
            'response' => $response
        ];

        return json_encode($res);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        // Condition
        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_id('Condition', $id);
        $res = [
            'status' => $statusCode,
            'response' => $response
        ];

        $data = json_decode(json_encode($response),TRUE);
        $id   = $data['id'];

        // return json_encode($id);
        return json_encode($res);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $kategori = $request->kategori;
        $kode_icd_10 = $request->kode_icd_10;
        $id_pasien = $request->id_pasien;
        $nama_pasien = $request->nama_pasien;
        $id_encounter = $request->id_encounter;
        $waktu_onset = $request->waktu_onset;
        $waktu_recorded = $request->waktu_recorded;
        // Condition
        $condition = new Condition;
        $condition->addClinicalStatus(); // active, inactive, resolved. Default bila tidak dideklarasi = active
        $condition->addCategory($kategori); // Diagnosis, Keluhan. Default : Diagnosis
        $condition->addCode($kode_icd_10); // Kode ICD10
        $condition->setSubject( $id_pasien , $nama_pasien); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $condition->setEncounter($id_encounter); // ID SATUSEHAT Encounter
        $condition->setOnsetDateTime( $waktu_onset); // timestamp onset. Timestamp sekarang
        $condition->setRecordedDate($waktu_recorded); // timestamp recorded. Timestamp sekarang
        $condition->json();

        [$statusCode, $response] = $condition->put($id);
        $res = [
            'status' => $statusCode,
            'response' => $response
        ];

        return json_encode($res);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
