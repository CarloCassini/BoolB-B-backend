<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Visualization;
use Carbon\Carbon;

// supports
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

// importo i modelli
use app\Models\User;
use App\Models\Apartment;
use App\Models\Service;




class ApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * *@return \Illuminate\Http\Response
     */
    public function index()
    {
        // prendo id user dallo user loggato
        $user = Auth::user();

        $apartments = Apartment::orderBy('id', 'desc')->where('user_id', '=', $user->id)->paginate(12);
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // prendo i services in ordine alfabetico 
        $services = Service::orderBy('label')->get();
        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     //  * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentRequest $request)
    {
        // prendo id user dallo user loggato
        $user = Auth::user();

        $data = $request->validated();
        $apartment = new Apartment;

        // inserisco i dati ricevuti nel data
        $apartment->fill($data);

        // user_id viene valorizzato in base a chi è collegato
        $apartment->user_id = $user->id;

        // //todo -> forso l'inserimento dei campi per vedere il salvataggio

        // $client = new Client([
        //     'true' => false, // Ignora la verifica SSL
        // ]);
        // dd($client->get('https://api.tomtom.com/search/2/geocode/Rome.json?key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P'));
        // $response = $client->get('https://api.tomtom.com/search/2/geocode/Rome.json?key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P');
        // // Effettua una richiesta GET a un endpoint API
        // // $response = Http::get('https://api.tomtom.com/search/2/geocode/Rome.json?key=t7a52T1QnfuvZp7X85QvVlLccZeC5a9P');

        // $data2 = json_decode($response->getBody(), true);
        // // Esempio di come accedere ai dati di risposta
        // // $data2 = $response->json();

        // // Fai qualcosa con i dati ottenuti

        // dd($data2);
        // return response()->json(['data' => $data2]);



        $apartment->latitude = 200;
        $apartment->longitude = 200;

        $apartment->save();

        if (Arr::exists($data, "services"))
            $apartment->services()->attach($data["services"]);

        return view('admin.apartments.show', compact('apartment'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment, Request $request, Visualization $visualization)
    {
        // * gestione rotte protette
        $user = Auth::user();
        if ($user->id != $apartment->user_id) {
            return redirect()->back()->with([
                'not_allowed_message' => 'sorry, u can\'t touch this'
            ]);
        }
        // *fine gestione rotta protetta

        $visualization = new Visualization;
        $visualization->apartment_id = $apartment->id;
        $visualization->ip = $request->ip();
        $visualization->date = Carbon::now();

        $services = Service::all();

        // $visualization->fill();
        $visualization->save();


        return view('admin.apartments.show', compact('apartment', 'services'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {
        // * gestione rotte protette
        $user = Auth::user();
        if ($user->id != $apartment->user_id) {
            return redirect()->back()->with([
                'not_allowed_message' => 'sorry, u can\'t touch this'
            ]);
        }
        // *fine gestione rotta protetta

        $services = Service::orderBy('label')->get();
        $apartment_service = $apartment->services->pluck('id')->toArray();
        return view('admin.apartments.edit', compact('apartment', 'services', 'apartment_service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        // * gestione rotte protette
        $user = Auth::user();
        if ($user->id != $apartment->user_id) {
            return redirect()->back()->with([
                'not_allowed_message' => 'sorry, u can\'t touch this'
            ]);
        }
        // *fine gestione rotta protetta

        $data = $request->validated();
        // $apartment->fill($data);
        $apartment->update($data);


        if (Arr::exists($data, "services")) {
            $apartment->services()->sync($data["services"]);
        } else {
            $apartment->services()->detach();
        }

        return redirect()->route('admin.apartments.show', $apartment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Apartment  $apartment
    //  * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Apartment $apartment)
    {
        // * gestione rotte protette
        $user = Auth::user();
        if ($user->id != $apartment->user_id) {
            return redirect()->back()->with([
                'not_allowed_message' => 'sorry, u can\'t touch this'
            ]);
        }
        // *fine gestione rotta protetta

        $apartment->services()->detach();
        if ($request->hasFile('cover_image')) {
            Storage::delete($apartment->cover_image_path);
        }
        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }
}