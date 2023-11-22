<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // todo : togliere i commenti quando avremo le tabelle
    // ** per i messaggi
    // public function messages()
    // {
    //     return $this->hasMany(Messages::class);
    // }

    // ** per le foto
    // public function photos() {
    //     return $this->hasMany(Photo::class);
    //   }

    // ** per le views
    // public function views() {
    //     return $this->hasMany(View::class);
    //   }

    // !! relazioni molti a molti
    // ** per i servizi
    // public function services() {
    //     return $this->belongsToMany(Service::class);
    //   }

    // **per gli sponsor
    // public function sponsors() {
    //     return $this->belongsToMany(Sponsor::class);
    //   }
}