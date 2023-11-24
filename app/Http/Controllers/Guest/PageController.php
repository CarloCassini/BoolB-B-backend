<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;


// models usati
use App\Models\Apartment;
use App\Models\Visualization;
use App\Models\Service;

class PageController extends Controller
{
  public function index()
  {
    $apartments = Apartment::orderBy('id', 'desc')->paginate(12);
    return view('guest.home', compact('apartments'));
  }

  public function show(Apartment $apartment, Request $request, Visualization $visualization)
  {
    // dd($apartment);
    $apartment = Apartment::where('id', '=', $apartment->id)->first();

    // dd($request->getQueryString());
    // dd($apartment);

    $visualization = new Visualization;
    $visualization->apartment_id = $apartment->id;
    $visualization->ip = $request->ip();
    $visualization->date = Carbon::now();
    // $visualization->fill();
    $visualization->save();

    $services = Service::all();


    return view('guest.apartments.show', compact('apartment', 'services'));
  }
}