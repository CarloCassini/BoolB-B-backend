<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Models\Message;
use App\Models\Apartment;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Funzione per l'invio deimessaggi
    public function inviaMessaggio(Request $request)
    {
        // Validazione dei dati inviati dal form
        $validatedData = $request->validate([
            'sender_email' => 'required|email',
            'name' => 'nullable|string',
            'surname' => 'nullable|string',
            'message' => 'required|string',
            'apartment_id' => 'required|numeric',
        ]);
        // Salvataggio del messaggio nel database
        $message = new Message();
        $message->name = $validatedData['name'];
        $message->surname = $validatedData['surname'];
        $message->sender_email = $validatedData['sender_email'];
        $message->message = $validatedData['message'];
        $message->apartment_id = $validatedData['apartment_id'];
        $message->save();

        return redirect()->back()->with('success', 'Messaggio inviato con successo!');
    }

    // lista messaggi utente registrato con appartamenti



    /**
     * Display a listing of the resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $messages = [];

        $messagesList = Apartment::join('messages', 'messages.apartment_id', '=', 'apartments.id')
            ->where('apartments.user_id', '=', $user_id)
            ->orderBy('messages.created_at', 'desc')->get();
        foreach ($messagesList as $message) {
            array_push($messages, $message);
        }
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        // * gestione rotte protette
        $user = Auth::user();
        $apartment = Apartment::join('messages', 'messages.apartment_id', '=', 'apartments.id')
            ->where('apartments.id', '=', $message->apartment_id)
            ->first();

        if ($user->id != $apartment->user_id) {
            return redirect()->back()->with([
                'not_allowed_message' => 'sorry, u can\'t touch this'
            ]);
        }
        // *fine gestione rotta protetta

        $message->delete();

        return redirect()->back();
        // return redirect()->route('admin.apartments.index');
    }
}