<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Satusehat\Integration\FHIR\Patient;
use Satusehat\Integration\OAuth2Client;

class PatientController extends Controller
{


    public function by_id(string $id)
    {
        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_id('Patient', $id);
        $res = [
            'status' => $statusCode,
            'response' => $response
        ];

        return json_encode($res);
    }
    public function by_nik(string $id)
    {
        $client = new OAuth2Client;
        [$statusCode, $response] = $client->get_by_nik('Patient', $id);
        $res = [
            'status' => $statusCode,
            'response' => $response
        ];

        $data = json_decode(json_encode($response), true);

        // Mengakses nilai kunci "id"
        $id = $data['entry'][0]['resource']['id'];

        // return json_encode($id);
        return json_encode($res);
    }


    public function store(Request $request)
    {
        // Patient
        $nik_type   = $request->nik_type;
        $nik        = $request->nik;
        $nama_pasien = $request->nama_pasien;
        $nomor_telepon = $request->nomor_telepon;
        $alamat     = $request->alamat;
        $kota       = $request->kota;
        $kode_pos   = $request->kode_pos;
        $rt         = $request->rt;
        $rw         = $request->rw;
        $jenis_kelamin  = $request->jenis_kelamin;
        $tgl_lahir      = $request->tgl_lahir;
        $status_kawin   = $request->status_kawin;
        $kode_provinsi  = $request->kode_provinsi;
        $kode_kabupaten = $request->kode_kabupaten;
        $kode_kecamatan = $request->kode_kecamatan;
        $kode_wilayah   = $request->kode_wilayah;
        $multipleBrith   = $request->multipleBrith;

        $patient = new Patient;
        $patient->addIdentifier($nik_type, $nik);
        $patient->setName($nama_pasien);

        $patient->addTelecom($nomor_telepon);

        $address_detail = [
            'address' => $alamat,
            'city' => $kota,
            'postalCode' => $kode_pos,
            'country' => 'id-ID', // Kode negara
            'provinceCode' => $kode_provinsi,
            'cityCode' => $kode_kabupaten,
            'districtCode' => $kode_kecamatan,
            'villageCode' => $kode_wilayah,
            'rt' => $rt,
            'rw' => $rw,
        ];

        $patient->setGender($jenis_kelamin);  //male/female
        $patient->setBirthDate($tgl_lahir);  //YYYY-MM-DD
        // $patient->setDeceased('{boolean}');
        $patient->setAddress($address_detail);

        $patient->setMaritalStatus($status_kawin);  // Married, unmarried, never, divorced, widowed

        $patient->setMultipleBirth(1); // menunjukkan urutan kelahiran yang sebenarnya

        // $patient->setEmergencyContact('{nama_kontak}', '{nomor_kontak}');
        $patient->setCommunication(); // Bahasa pasien, default Indonesian

        $patient->json();
        [$statusCode, $response] = $patient->post();

        $res = [
            'status' => $statusCode,
            'response' => $response,
        ];

        return json_encode($res);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
