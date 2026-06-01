<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $approvedReviews = Review::where('approved', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
        
        $rooms = Room::where('status', 'available')
            ->orderBy('type')
            ->take(6)
            ->get();

        $totalReviews = Review::where('approved', true)->count();
        $averageRating = Review::where('approved', true)->avg('rating');

        return view('public.home.index', compact('approvedReviews', 'rooms', 'totalReviews', 'averageRating'));
    }
}

