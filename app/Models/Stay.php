<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stay extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'room_id',
        'reservation_id',
        'check_in_at',
        'expected_check_out_at',
        'actual_check_out_at',
        'status',
        'notes',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'expected_check_out_at' => 'datetime',
        'actual_check_out_at' => 'datetime',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'stay_room');
    }
}
