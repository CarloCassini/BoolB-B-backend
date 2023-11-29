<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
  use HasFactory;
  protected $fillable = [
    "title",
    "rooms",
    "beds",
    "bathrooms",
    "m2",
    // "address",
    "description",
    'is_hidden',
    // 'cover_image_path',
    // 'latitude_int',
    // 'longitude_int',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  // todo : togliere i commenti quando avremo le tabelle
  // ** per i messaggi
  public function messages()
  {
    return $this->hasMany(Message::class);
  }

  // ** per le foto
  public function photos()
  {
    return $this->hasMany(Photo::class);
  }

  public function views()
  {
    return $this->hasMany(Visualization::class);
  }

  // !! relazioni molti a molti
  // ** per i servizi
  public function services()
  {
    return $this->belongsToMany(Service::class);
  }

  // **per gli sponsor
  public function sponsors()
  {
    return $this->belongsToMany(Sponsor::class);
  }
}