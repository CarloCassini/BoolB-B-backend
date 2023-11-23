<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
  protected $fillable = [
    'name',
    'price',
    'time',
];
protected $table = 'sponsors';
    use HasFactory;
    public function apartments() {
        return $this->belongsToMany(Apartment::class);
      }
}
