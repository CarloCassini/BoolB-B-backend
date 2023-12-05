<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\Message;

class PageController extends Controller
{
  public function index()
  {
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
  }
}