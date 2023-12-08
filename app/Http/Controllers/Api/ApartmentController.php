<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Visualization;

class ApartmentController extends Controller
{
    // per la ricerca dalla homepage
    public function sponsored()
    {
        $apartments = Apartment::with('services', )
            ->join('apartment_sponsor', 'apartment_sponsor.apartment_id', '=', 'apartments.id')
            ->select("apartments.id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path")
            ->where('is_hidden', '=', 0)
            ->paginate(8);


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
        $apartments = Apartment::with('services', )
            ->select("id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path")
            ->where('is_hidden', '=', 0)
            ->paginate(8);


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

        $services = Service::all();

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

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
            ->paginate(10);

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

        $apartments_query = Apartment::with('services')
            ->select("id", "user_id", "title", "rooms", "beds", "bathrooms", "m2", "address", "description", "cover_image_path")
            ->where('is_hidden', '=', 0);

        if (!empty($filters['activeServices'])) {
            $apartments_query->whereHas('services', function ($query) use ($filters) {
                $query->whereIn('services.id', $filters['activeServices']);
            });
        }
        if (!empty($filters['rooms'])) {
            $apartments_query->where("rooms", '>=', $filters['rooms']);
        }
        if (!empty($filters['beds'])) {
            $apartments_query->where("beds", '>=', $filters['beds']);
        }
        foreach ($apartments_query as $apartment) {
            if (!empty($apartment->description)) {
                $apartment->description = substr($apartment->description, 0, 50);
            }
        }
        $apartments = $apartments_query->paginate(9);

        return response()->json($apartments);

    }
}