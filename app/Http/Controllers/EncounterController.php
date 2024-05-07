<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Encounter;

$client = new OAuth2Client;

class EncounterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function show(string $id)
    {
        $client = new OAuth2Client;
        // Encounter
        [$statusCode, $response] = $client->get_by_id('Encounter', $id);
        $res = [
            'status' => $statusCode,
            'response' => $response
        ];
        $data = json_decode(json_encode($response), true);

        // Mengakses nilai kunci "id"
        $id = $data['id'];


        // return json_encode($id);
        return json_encode($res);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $kode_reg = $request->kode_registrasi;
        $waktu_kedatangan = $request->waktu_kedatangan;
        // $waktu_pemeriksaan = $request->waktu_pemeriksaan;
        // $waktu_akhir_pemeriksaan = $request->waktu_akhir_pemeriksaan;
        // $waktu_pulang = $request->waktu_pulang;
        $metode_konsultasi = $request->metode_konsultasi;
        $id_pasien = $request->id_pasien;
        $nama_pasien = $request->nama_pasien;
        $id_practitioner = $request->id_practitioner;
        $nama_dokter = $request->nama_dokter;
        $id_location = $request->id_location;
        $nama_poli = $request->nama_poli;

        // Encounter
        $encounter = new Encounter;

        $encounter->addRegistrationId($kode_reg); // unique string free text (increments / UUID)

        $encounter->setArrived($waktu_kedatangan);
        // $encounter->setInProgress($waktu_pemeriksaan, $waktu_akhir_pemeriksaan);
        // $encounter->setFinished($waktu_pulang);

        $encounter->setConsultationMethod($metode_konsultasi); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
        $encounter->setSubject($id_pasien, $nama_pasien); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $encounter->addParticipant($id_practitioner, $nama_dokter); // ID SATUSEHAT Dokter, Nama Dokter
        $encounter->addLocation($id_location, $nama_poli); // ID SATUSEHAT Location, Nama Poli
        $encounter->json();
        [$statusCode, $response] = $encounter->post();

        $res = [
            'status' => $statusCode,
            'response' => $response,
        ];

        return json_encode($res);
    }

    /**
     * Display the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kode_reg = $request->kode_registrasi;
        $waktu_kedatangan = $request->waktu_kedatangan;
        $waktu_pemeriksaan = $request->waktu_pemeriksaan;
        $waktu_akhir_pemeriksaan = $request->waktu_akhir_pemeriksaan;
        $waktu_pulang = $request->waktu_pulang;
        $metode_konsultasi = $request->metode_konsultasi;
        $id_pasien = $request->id_pasien;
        $nama_pasien = $request->nama_pasien;
        $id_practitioner = $request->id_practitioner;
        $nama_dokter = $request->nama_dokter;
        $id_location = $request->id_location;
        $nama_poli = $request->nama_poli;
        $encounter_id = $request->encounter_id;

        // Encounter
        $encounter = new Encounter;

        $encounter->addRegistrationId($kode_reg); // unique string free text (increments / UUID)

        $encounter->setArrived($waktu_kedatangan);
        $encounter->setInProgress($waktu_pemeriksaan, $waktu_akhir_pemeriksaan);
        $encounter->setFinished($waktu_pulang);

        $encounter->setConsultationMethod($metode_konsultasi); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
        $encounter->setSubject($id_pasien, $nama_pasien); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $encounter->addParticipant($id_practitioner, $nama_dokter); // ID SATUSEHAT Dokter, Nama Dokter
        $encounter->addLocation($id_location, $nama_poli); // ID SATUSEHAT Location, Nama Poli
        $encounter->json();
        [$statusCode, $response] = $encounter->put($encounter_id);

        $res = [
            'status' => $statusCode,
            'response' => $response,
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
