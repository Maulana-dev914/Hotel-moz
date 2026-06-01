<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create()
    {
        return view('public.reviews.create');
    }

    public function store(StoreReviewRequest $request)
    {
        Review::create($request->validated());
        return redirect()->route('public.review.create')->with('success', 'Avaliação enviada com sucesso! Aguarde aprovação do administrador.');
    }
}
