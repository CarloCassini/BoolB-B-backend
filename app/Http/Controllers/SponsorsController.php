<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsor;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Braintree\Gateway;
use Carbon\Carbon;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $sponsors = Sponsor::all();
        $userApartments = auth()->user()->apartments;
        $userSponsors = auth()->user()->sponsors;
        $apartments = Apartment::all()->where('user_id', $user_id);


        return view('admin.sponsors.index', compact('userSponsors', 'userApartments', 'sponsors', 'user_id', 'apartments'));
    }

    // crezione sponsor
    public function sponsorship(Request $request)
    {
        // in data mi arrivano tutti i dati del pagamento stesso
        $data = $request->all();
        $paymentMethod = "creditCard";
        $sponsorId = $data['sponsor_id'];
        $find_sponsor = Sponsor::find($sponsorId);
        $apartmentId = $data['apartment_id'];
        $apartment = Apartment::find($apartmentId);
        $nonce = $request->payment_method_nonce;
        $price = $find_sponsor->price;

        // Effettua il pagamento utilizzando Braintree
        // lo passo fisso senza modificare l'env
        $gateway = new Gateway([
            'environment' => 'sandbox',
            'merchantId' => 't2zvx4dq3yfyv9z3',
            'publicKey' => 'wz8nmzd5x4tv82w8',
            'privateKey' => 'a248f8086c7f1ae66b34ee610471568f'
        ]);
        // Gestisci il pagamento in base al metodo selezionato
        if ($paymentMethod === 'creditCard') {
            // Elabora la transazione con carta di credito
            $result = $gateway->transaction()->sale([
                'amount' => $price,
                'paymentMethodNonce' => $nonce,
                'options' => [
                    'submitForSettlement' => true,
                ],
            ]);

        } elseif ($paymentMethod === 'paypal') {
            // Elabora la transazione con PayPal
            // Implementa la logica per il pagamento PayPal
            // al momento assente
        }

        // Gestisci la risposta di Braintree e restituisci una vista appropriata
        if ($result->success) {

            $new_data_inizio = now();
            $new_data_calcoli = now();

            // verifico quale sia l'ultimo record della tabella apartment_sponsor
            $Sponsor_exist = Apartment::join('apartment_sponsor', 'apartment_sponsor.apartment_id', '=', 'apartments.id')
                ->where('apartments.id', '=', $apartment->id)
                ->orderByDesc('apartment_sponsor.start_date')
                ->first();

            if ($Sponsor_exist) {
                $new_data_inizio = Carbon::parse($Sponsor_exist->end_date);
                $new_data_calcoli = Carbon::parse($Sponsor_exist->end_date);
            }

            // *al massimo devo inventarmi un modo di aggiungere tempo alla sponsorizzata
            $endDateForSponsor = [
                1 => $new_data_calcoli->addDays(1)->format('Y-m-d H:i:s'), // Sponsor 1: 1 giorno dopo la data di inizio
                2 => $new_data_calcoli->addDays(2)->format('Y-m-d H:i:s'), // Sponsor 2: 3 giorni dopo la data di inizio
                3 => $new_data_calcoli->addDays(3)->format('Y-m-d H:i:s'), // Sponsor 3: 6 giorni dopo la data di inizio
            ];

            $endDate = $endDateForSponsor[$data["sponsor_id"]] ?? null;

            $apartment->sponsors()->attach($data["sponsor_id"], [
                'start_date' => $new_data_inizio,
                'end_date' => $endDate,

            ]);

            $momento_seguente_salvataggio = now()->addMinute();
            $sponsor = Sponsor::join('apartment_sponsor', 'apartment_sponsor.sponsor_id', '=', 'sponsors.id')
                ->where('apartment_sponsor.apartment_id', '=', $apartment->id)
                ->where('apartment_sponsor.start_date', '<', $momento_seguente_salvataggio)
                ->where('apartment_sponsor.end_date', '>', $momento_seguente_salvataggio)
                ->first();
            $services = Service::all();
            return view('admin.apartments.show', compact('apartment', 'services', 'sponsor'));
        } else {
            return redirect()->back()->with([
                'payment-error' => 'payment error'
            ]);
        }

    }

    public function selectSponsor($apartment_id)
    {

        // uso una chiave fissa per le autorizzazioni
        // sandbox_fw47smcq_t2zvx4dq3yfyv9z3


        $sponsors = Sponsor::all();

        return view('admin.sponsors.select', compact('sponsors', 'apartment_id', ));

    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.sponsors.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show(Sponsor $sponsor)
    {
        $apartmentSponsor = Sponsor::all()->where();

        return view('admin.sponsors.show', compact('sponsor', 'sponsorship'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}