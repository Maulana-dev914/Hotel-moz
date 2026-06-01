<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'document',
        'document_type',
        'phone',
        'email',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function stays()
    {
        return $this->hasMany(Stay::class);
    }
}
