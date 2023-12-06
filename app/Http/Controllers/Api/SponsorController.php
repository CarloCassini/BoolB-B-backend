<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Braintree\Gateway;

class SponsorController extends Controller {
    public function generate(Request $request) {
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 't2zvx4dq3yfyv9z3',
            'publicKey' => 'wz8nmzd5x4tv82w8',
            'privateKey' => 'a248f8086c7f1ae66b34ee610471568f'
        ]);


        $clientToken = $gateway->clientToken()->generate();


        return $clientToken;
        //
    }
    public function makePayment(Request $request) {
        return 'make Payment';
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }
}