<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visualization extends Model
{
    use HasFactory;
    protected $fillable = [
        'apartment_id',
        'date',
        'ip',
    ];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
