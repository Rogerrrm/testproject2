<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'restaurant_id'
    ];

    // Relación con el usuario que hizo la calificación
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el restaurante que se está calificando
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}