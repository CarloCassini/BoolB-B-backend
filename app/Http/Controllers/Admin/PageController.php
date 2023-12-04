<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;

class PageController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $apartments = Apartment::orderBy('id', 'desc')->where('user_id', '=', $user->id)->paginate(12);
    return view('admin.dashboard', compact('apartments'));
    // return view('admin.dashboard');
  }
}