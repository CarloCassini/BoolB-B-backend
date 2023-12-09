<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Sponsor;
use App\Models\Visualization;
use App\Models\Message;
use Carbon\Carbon;

// supports
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

        // store dell'immagine nella cartella uploads(collegamento storage)
        if (Arr::exists($data, "cover_image_path")) {
            $apartment->cover_image_path = Storage::put("uploads/apartments/cover_image", $data['cover_image_path']);
        }

        // user_id viene valorizzato in base a chi è collegato
        $apartment->user_id = $user->id;

        // todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        // * ++++ gestione latitudine e longitudine e indirizzo
        // *l'indirizzo è inteso come lat|lon|indirizzo
        $indirizzo = $data['address'];
        $separatore = '|';

        $indirizzo_esploso = explode($separatore, $indirizzo);
        // * quindi l'indirizzo esploso è sempre con 
        // *[0]=lat
        // *[1]=lon
        // *[2]=indirizzo umano
        // * il che mi permette di ridistribuire le informazioni agli elementi prima del salvataggio
        $apartment->latitude = $indirizzo_esploso[0];
        $apartment->longitude = $indirizzo_esploso[1];
        $apartment->address = $indirizzo_esploso[2];
        // todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

        $apartment->save();

        $sponsor = Sponsor::join('apartment_sponsor', 'apartment_sponsor.sponsor_id', '=', 'sponsors.id')
            ->where('apartment_sponsor.apartment_id', '=', $apartment->id)
            ->first();

        if (Arr::exists($data, "services"))
            $apartment->services()->attach($data["services"]);

        return view('admin.apartments.show', compact('apartment', 'sponsor'));

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

        $oggi = now();
        $sponsor = Sponsor::join('apartment_sponsor', 'apartment_sponsor.sponsor_id', '=', 'sponsors.id')
            ->where('apartment_sponsor.apartment_id', '=', $apartment->id)
            ->where('apartment_sponsor.start_date', '<', $oggi)
            ->where('apartment_sponsor.end_date', '>', $oggi)
            ->first();


        $visualization = new Visualization;
        $visualization->apartment_id = $apartment->id;
        $visualization->ip = $request->ip();
        $visualization->date = Carbon::now();

        $services = Service::all();

        // $visualization->fill();
        $visualization->save();


        return view('admin.apartments.show', compact('apartment', 'services', 'sponsor'));
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

        // store dell'immagine nella cartella uploads(collegamento storage)
        if (Arr::exists($data, "cover_image_path")) {
            if ($apartment->cover_image_path) {
                Storage::delete($apartment->cover_image_path);
            }
            $apartment->cover_image_path = Storage::put("uploads/apartments/cover_image", $data['cover_image_path']);
        }

        // todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        // * ++++ gestione latitudine e longitudine e indirizzo
        // *l'indirizzo è inteso come lat|lon|indirizzo
        $indirizzo = $data['address'];
        $separatore = '|';

        $indirizzo_esploso = explode($separatore, $indirizzo);
        // * quindi l'indirizzo esploso è sempre con 
        // *[0]=lat
        // *[1]=lon
        // *[2]=indirizzo umano
        // * il che mi permette di ridistribuire le informazioni agli elementi prima del salvataggio
        $apartment->latitude = $indirizzo_esploso[0];
        $apartment->longitude = $indirizzo_esploso[1];
        $apartment->address = $indirizzo_esploso[2];
        // todo xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
        $apartment->update($data);


        if (Arr::exists($data, "services")) {
            $apartment->services()->sync($data["services"]);
        } else {
            $apartment->services()->detach();
        }

        $sponsor = Sponsor::join('apartment_sponsor', 'apartment_sponsor.sponsor_id', '=', 'sponsors.id')
            ->where('apartment_sponsor.apartment_id', '=', $apartment->id)
            ->first();

        return redirect()->route('admin.apartments.show', compact('apartment', 'sponsor'));
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
        if ($apartment->cover_image_path) {
            Storage::delete($apartment->cover_image_path);
        }

        // cancello anche i messaggi che hanno l'appartamento
        $apartment->messages()->delete();
        $apartment->delete();

        // invio alla pagina my apartment
        // return redirect()->route('admin.apartments.index');

        // todo invio alla dashboard +++++++++++++++++++++++++
        // per gli appartamenti
        $user = Auth::user();
        $apartments = Apartment::orderBy('id', 'desc')->where('user_id', '=', $user->id)->paginate(12);
        // fine appartamenti

        // per i messaggi
        $user_id = $user->id;
        $messages = [];

        $messagesList = Apartment::join('messages', 'messages.apartment_id', '=', 'apartments.id')
            ->where('apartments.user_id', '=', $user_id)
            ->orderBy('messages.created_at', 'desc')->get();

        foreach ($messagesList as $message) {
            array_push($messages, $message);
        }
        // fine messaggi

        return view('admin.dashboard', compact('apartments', 'messages'));
        // todo +++++++++++++++++++++++++++++++++++++++++++++++
    }

    // statistiche appartamento (visualizzazioni + messaggi)  
    public function showStatistics($apartment_id)
    {
        // Recupera il numero di visualizzazioni per l'appartamento specifico (mesi/anni)
        $visualizationCounts = Visualization::selectRaw('YEAR(date) as year, MONTH(date) as month, COUNT(*) as count')
            ->where('apartment_id', $apartment_id)
            ->groupBy('year', 'month')
            ->get();

        // Recupera il numero di messaggi per l'appartamento specifico
        $messageCounts = Message::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->where('apartment_id', $apartment_id)
            ->groupBy('year', 'month')
            ->get();

        return view('admin.statistics.show', compact('visualizationCounts', 'messageCounts', 'apartment_id'));
    }
}