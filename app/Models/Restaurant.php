<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'latitude',
        'longitude',
        'average_rating',
        'user_id'
    ];

    // Relación con el usuario propietario del restaurante
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}