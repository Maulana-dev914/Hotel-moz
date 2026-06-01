<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::where('status', 'available')->orderBy('type')->orderBy('number')->get();
        return view('public.rooms.index', compact('rooms'));
    }
}
