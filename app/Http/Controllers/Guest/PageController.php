<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// models usati
use App\Models\Apartment;
use App\Models\Visualization;
use App\Models\Service;

class PageController extends Controller
{
  public function index()
  {
    // $apartments = Apartment::orderBy('id', 'desc')->where('is_hidden', '=', '0')->paginate(12);
    // return view('guest.home', compact('apartments'));
    // return view('auth.login');

    if (Auth::user()) {

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
    } else {
      return view('auth.login');
    }
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