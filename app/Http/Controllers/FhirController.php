<?php

namespace App\Http\Controllers;

use App\Models\Fhir;
use App\Http\Requests\StoreFhirRequest;
use App\Http\Requests\UpdateFhirRequest;
use Illuminate\Support\Str;

use Satusehat\Integration\OAuth2Client;


class FhirController extends Controller
{

    // Token Test
    public function token()
    {
        $client = new OAuth2Client;
        $token = $client->token();

        $res = [
            'status' => 200,
            'response' => 'success generate token.',
            'token' => $token
        ];

        return json_encode($res);
    }
}
