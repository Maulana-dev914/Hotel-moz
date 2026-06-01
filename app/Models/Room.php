<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'price',
        'status',
        'max_adults',
        'max_children',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reservationsMany()
    {
        return $this->belongsToMany(Reservation::class, 'reservation_room');
    }

    public function stays()
    {
        return $this->hasMany(Stay::class);
    }

    public function isAvailable()
    {
        return $this->status === 'available';
    }
}
