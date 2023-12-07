<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

        return response()->json([
            'status' => 'success',
            'message' => 'ok',
            'results' => 'saved',
            'success' => 'true',
            // 'description' => substr($apartments->description, 0, 50)
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        //
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

}