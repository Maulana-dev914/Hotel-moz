<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update(['approved' => true]);
        return redirect()->route('admin.reviews.index')->with('success', 'Avaliação aprovada!');
    }

    public function disapprove(Review $review)
    {
        $review->update(['approved' => false]);
        return redirect()->route('admin.reviews.index')->with('success', 'Avaliação reprovada!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Avaliação excluída com sucesso!');
    }
}
