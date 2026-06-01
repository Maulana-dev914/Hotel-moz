@extends('layouts.public')

@section('title', 'Deixar Avaliação - Hotel Moz')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-12 text-center mb-4">
            <h1>Deixar Avaliação</h1>
            <p class="lead">Sua opinião é muito importante para nós!</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('public.review.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="rating" class="form-label">Nota (1 a 5)</label>
                            <select class="form-select" id="rating" name="rating" required>
                                <option value="">Selecione...</option>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 - Excelente</option>
                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 - Muito Bom</option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 - Bom</option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 - Regular</option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 - Ruim</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Comentário</label>
                            <textarea class="form-control" id="comment" name="comment" rows="5" required>{{ old('comment') }}</textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Enviar Avaliação</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

