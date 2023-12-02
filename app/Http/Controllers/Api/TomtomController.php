<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class TomtomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function findsuggest($address)
    {
        // todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        // * ++++ gestione latitudine e longitudine
        // *forzo il fatto di non usare la verifica ssl
        $client = new Client([
            'verify' => false, // Ignora la verifica SSL
        ]);
        // inserisco l'indirizzo fornito nella chiamata api tomtom
        $response = $client->get('https://api.tomtom.com/search/2/search/' . $address . '.json?relatedPois=off&key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P');
        // https://api.tomtom.com/search/2/geocode/via guidi 15 padova.json?key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P
        // https://api.tomtom.com/search/2/search/padova.json?relatedPois=off&key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P

        $data_position = json_decode($response->getBody(), true);

        // dd($data_position);
        // * ++++ fine gestione latitudine e longitudine
        // todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        return $data_position;
    }
}