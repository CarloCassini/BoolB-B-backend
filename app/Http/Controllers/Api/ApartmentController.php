<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Visualization;
use Illuminate\Support\Facades\DB;


class ApartmentController extends Controller
{
    // per la ricerca dalla homepage
    public function sponsored()
    {
        $now = now();
        $apartments = Apartment::with('services', )
            ->join('apartment_sponsor', 'apartment_sponsor.apartment_id', '=', 'apartments.id')
            ->select("apartments.id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path")
            ->where('apartment_sponsor.start_date', '<=', $now)
            ->where('apartment_sponsor.end_date', '>=', $now)
            ->where('is_hidden', '=', 0)
            ->orderByDesc('apartment_sponsor.start_date')
            ->paginate(50);


        foreach ($apartments as $apartment) {
            if (!empty($apartment->description)) {
                $apartment->description = substr($apartment->description, 0, 50);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'results' => $apartments,
            // 'description' => substr($apartments->description, 0, 50)
        ], 200);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::with('services',)
            ->select("id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path")
            ->where('is_hidden', '=', 0)
            ->paginate(50);


        foreach ($apartments as $apartment) {
            if (!empty($apartment->description)) {
                $apartment->description = substr($apartment->description, 0, 50);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'results' => $apartments,
            // 'description' => substr($apartments->description, 0, 50)
        ], 200);

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
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $apartment = Apartment::with('services', )
            ->select("id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path", "latitude", "longitude")
            ->where('id', $id)
            ->first();

        // conteggio visualizzazioni +++++++++++++
        $visualization = new Visualization;
        $visualization->apartment_id = $apartment->id;
        $visualization->ip = $request->ip();
        $visualization->date = Carbon::now();
        // $visualization->fill();
        $visualization->save();
        //+++++++++++++++++++++++++++++++++++++++++


        if ($apartment) {
            return response()->json([
                'status' => 'success',
                'message' => 'ok',
                'results' => $apartment
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Apartment not found !'
            ], 404);
        }
    }


    // ! FILTERED ----------------------------------------------------------------
    /* 
     *   Apartment by Service
     *
     *
     */
    public function ApartmentByService($service_id)
    {

        $apartments = Apartment::with('services', )
            ->select("apartments.id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path")
            ->join('apartment_service', 'apartments.id', '=', 'apartment_service.apartment_id')
            ->where('is_hidden', '=', 0 && 'apartment_service.service_id', '=', $service_id)
            // ->where('apartment_service.service_id', '=', $service_id)
            ->paginate(50);

        foreach ($apartments as $apartment) {
            if (!empty($apartment->description)) {
                $apartment->description = substr($apartment->description, 0, 50);
            }
        }


        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'results' => $apartments,
            // 'description' => substr($apartments->description, 0, 50)
        ], 200);

    }
    /* 
     *   Apartment by filter
     *
     *
     */
    public function apartmentsByFilters(Request $request)
    {
        // filtri ricevuti
        $filters = $request->all();

        // Ottenere le coordinate e la distanza dalla richiesta
        $lat = $filters['lat'];
        $long = $filters['long'];
        $distance = $filters['distance'];

        // Calcolare i limiti della bounding box rettangolare
        $latDelta = abs($distance / 111.32); // 1 grado di latitudine è circa 111.32 km
        $longDelta = abs($distance / (111.32 * cos(deg2rad($lat))));

        $minLat = $lat - $latDelta;
        $maxLat = $lat + $latDelta;
        $minLong = $long - $longDelta;
        $maxLong = $long + $longDelta;

        Log::info("minLat: $minLat, maxLat: $maxLat, minLong: $minLong, maxLong: $maxLong");

        // cerco gli appartamenti nella zona con sponsorizzazione
        $now = now();

        $apartments_sponsor = Apartment::with('services')
            ->select("apartments.id", "apartment_sponsor.apartment_id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path", "latitude", "longitude")
            ->join('apartment_sponsor', 'apartment_sponsor.apartment_id', '=', 'apartments.id')
            ->where('is_hidden', '=', 0)
            ->whereBetween('latitude', [$minLat, $maxLat])
            ->whereBetween('longitude', [$minLong, $maxLong])
            ->where('apartment_sponsor.start_date', '<=', $now)
            ->where('apartment_sponsor.end_date', '>=', $now)
            ->orderByDesc('apartment_sponsor.start_date');

        // cerco tutti gli appartamenti nella zona senza sponsor che non sono stati già trovati
        $apartments_all = Apartment::with('services')
            ->select("apartments.id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path", "latitude", "longitude")
            ->where('is_hidden', '=', 0)
            ->whereBetween('latitude', [$minLat, $maxLat])
            ->whereBetween('longitude', [$minLong, $maxLong]);

        // miglioramento logica apartment_sponsor

        $apartments_query_sponsor = $apartments_sponsor;
        if ($apartments_query_sponsor) {
            if (!empty($filters['activeServices'])) {
                foreach ($filters['activeServices'] as $service) {
                    $apartments_query_sponsor->whereHas('services', function ($query) use ($service) {
                        $query->where('services.id', $service);
                    });
                }
            }
            // if (!empty($filters['activeServices'])) {
            //     $apartments_query_sponsor->whereHas('services', function ($query) use ($filters) {
            //         // $query->whereIn('services.id', $filters['activeServices']);
            //         $query->where('services.id', $filters['activeServices']);
            //     });
            // }
            if (!empty($filters['rooms'])) {
                $apartments_query_sponsor->where("rooms", '>=', $filters['rooms']);
            }
            if (!empty($filters['beds'])) {
                $apartments_query_sponsor->where("beds", '>=', $filters['beds']);
            }
            foreach ($apartments_query_sponsor as $apartment) {
                if (!empty($apartment->description)) {
                    $apartment->description = substr($apartment->description, 0, 50);
                }
            }
        }

        // miglioramento logica apartment_all
        $apartments_query_all = $apartments_all;
        if ($apartments_query_all) {
            if (!empty($filters['activeServices'])) {
                foreach ($filters['activeServices'] as $service) {
                    $apartments_query_all->whereHas('services', function ($query) use ($service) {
                        $query->where('services.id', $service);
                    });
                }
            }
            // if (!empty($filters['activeServices'])) {
            //     $apartments_query_all->whereHas('services', function ($query) use ($filters) {
            //         // $query->whereIn('services.id', $filters['activeServices']);
            //         $query->where('services.id', $filters['activeServices']);
            //     });
            // }
            if (!empty($filters['rooms'])) {
                $apartments_query_all->where("rooms", '>=', $filters['rooms']);
            }
            if (!empty($filters['beds'])) {
                $apartments_query_all->where("beds", '>=', $filters['beds']);
            }
            foreach ($apartments_query_all as $apartment) {
                if (!empty($apartment->description)) {
                    $apartment->description = substr($apartment->description, 0, 50);
                }
            }
        }

        // $apartments = $apartments_query->paginate(18);
        $apartments_sponsor_ready = $apartments_query_sponsor->paginate(50);
        $apartments_all_ready = $apartments_query_all->paginate(50);


        // return response()->json($apartments);
        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            // 'results' => $apartments,
            'results' => ['sponsored' => $apartments_sponsor_ready, 'all' => $apartments_all_ready],
            // 'description' => substr($apartments->description, 0, 50)
        ], 200);
    }
}