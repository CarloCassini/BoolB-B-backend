<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Message;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }
}