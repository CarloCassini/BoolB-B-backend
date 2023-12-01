<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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
        $data=$request->all();

        $apartment=Apartment::find($data['apartment_id']);
        $endDateForSponsor = [
            1 => now()->addDays(1)->format('Y-m-d H:i:s'), // Sponsor 1: 1 giorno dopo la data di inizio
            2 => now()->addDays(3)->format('Y-m-d H:i:s'), // Sponsor 2: 3 giorni dopo la data di inizio
            3 => now()->addDays(6)->format('Y-m-d H:i:s'), // Sponsor 3: 6 giorni dopo la data di inizio
        ];

        $endDate = $endDateForSponsor[$data["sponsor_id"]] ?? null;

        $apartment->sponsors()->attach($data["sponsor_id"],[
            'start_date' => now(),
            'end_date' => $endDate,
        
        ]);
       
        return redirect()->route('admin.apartments.show', $apartment);

    }

    public function selectSponsor($apartment_id)
    {

        $sponsors = Sponsor::all();
       
        return view('admin.sponsors.select', compact('sponsors','apartment_id'));

    }

    /**
     * Show the form for creating a new resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("admin.sponsors.create");
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
        $apartmentSponsor = Sponsor::all() ->where();

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
