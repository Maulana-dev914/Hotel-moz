@extends('layouts.public')

@section('title', 'Hotel Moz - Bem-vindo')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container text-center">
        <div class="mb-3">
            @for($i = 1; $i <= 5; $i++)
                <i class="bi bi-star-fill" style="color: var(--gold); font-size: 1.5rem;"></i>
            @endfor
        </div>
        <h1>HOTEL MOZ</h1>
        <p class="lead">Localizado no coração da cidade, este hotel luxuoso e moderno oferece comodidades de primeira classe para uma estadia perfeita.</p>
        <div class="mt-4">
            <a href="{{ route('public.rooms.index') }}" class="btn btn-gold btn-lg me-2">EXPLORAR <i class="bi bi-arrow-right"></i></a>
            <a href="{{ route('public.availability.index') }}" class="btn btn-outline-light btn-lg"><i class="bi bi-calendar-check"></i> RESERVAR</a>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-light py-4">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4">
                <p class="mb-0" style="color: var(--dark-brown); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px;">DESDE 2020</p>
                <p class="mb-0" style="font-size: 0.8rem;">{{ date('Y') - 2020 }} ANOS DE OPERAÇÃO</p>
            </div>
            <div class="col-md-4">
                <p class="mb-0" style="color: var(--dark-brown); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px;">+{{ $totalReviews ?? 0 }}K</p>
                <p class="mb-0" style="font-size: 0.8rem;">Avaliações</p>
            </div>
            <div class="col-md-4">
                <p class="mb-0" style="color: var(--dark-brown); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px;">{{ number_format($averageRating ?? 0, 1) }}/5</p>
                <p class="mb-0" style="font-size: 0.8rem;">⭐ {{ $totalReviews ?? 0 }}K Reviews</p>
            </div>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="container my-5 py-5">
    <div class="row g-4">
        <div class="col-md-3">
            <div class="feature-card">
                <i class="bi bi-geo-alt-fill feature-icon"></i>
                <h5>Localização Privilegiada</h5>
                <p class="text-muted">Localizado no coração da cidade para fácil acesso e conveniência.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-card">
                <i class="bi bi-bag-check-fill feature-icon"></i>
                <h5>Luxuoso, Moderno e Confortável</h5>
                <p class="text-muted">Desfrute de um espaço luxuoso, moderno e totalmente equipado para conforto.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-card">
                <i class="bi bi-people-fill feature-icon"></i>
                <h5>Equipe Amigável</h5>
                <p class="text-muted">Nossa equipe amigável e acolhedora garante uma estadia deliciosa sempre.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="feature-card">
                <i class="bi bi-currency-dollar feature-icon"></i>
                <h5>Melhores Preços</h5>
                <p class="text-muted">Aproveite preços imbatíveis com ofertas fantásticas feitas sob medida para você.</p>
            </div>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="row g-2">
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400" class="img-fluid rounded" alt="Quarto 1">
                    </div>
                    <div class="col-6">
                        <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400" class="img-fluid rounded" alt="Quarto 2">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <p class="section-subtitle">Bem-vindo ao Hotel Moz</p>
                <h2 class="section-title">Hotel luxuoso no coração da cidade</h2>
                <p>O Hotel Moz, no coração da cidade, oferece mais de 100 quartos modernos e luxuosos. Desfrute de instalações premium, perfeitas para relaxamento e indulgência. Nossa equipe amigável garante uma experiência perfeita e personalizada, com vistas deslumbrantes da cidade. Descubra verdadeiro luxo e hospitalidade no Hotel Moz.</p>
                <a href="{{ route('public.rooms.index') }}" class="btn btn-gold mt-3">SAIBA MAIS <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Rooms Section -->
@if(isset($rooms) && $rooms->count() > 0)
<div class="container my-5 py-5">
    <p class="section-subtitle text-center">EXQUISITO E LUXUOSO</p>
    <h2 class="section-title text-center mb-5">Coleção de Quartos e Suítes</h2>
    <div class="row g-4">
        @foreach($rooms->take(3) as $room)
        <div class="col-md-4">
            <div class="room-card card">
                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600" class="card-img-top" alt="Quarto {{ $room->number }}">
                <div class="card-body">
                    <p class="text-muted mb-2" style="font-size: 0.9rem;">A partir de: <span class="room-price">{{ number_format($room->price, 0, ',', '.') }} MZN/NOITE</span></p>
                    <h5 class="card-title">
                        @if($room->type === 'single') Quarto Solteiro
                        @elseif($room->type === 'double') Quarto Duplo
                        @else Quarto Casal
                        @endif
                    </h5>
                    <p class="card-text">Quarto {{ $room->number }} - Confortável e moderno, este quarto oferece comodidades essenciais para uma estadia confortável.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('public.reservation.create', ['room_id' => $room->id]) }}" class="btn btn-gold">RESERVAR AGORA</a>
                        <a href="{{ route('public.rooms.index') }}" class="text-muted" style="text-decoration: none;">VER QUARTO <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('public.rooms.index') }}" class="btn btn-outline-dark btn-lg">VER TODOS OS QUARTOS</a>
    </div>
</div>
@endif

<!-- Amenities Section -->
<div class="bg-light py-5">
    <div class="container">
        <p class="section-subtitle text-center">MODERNO E CONFORTAVEL</p>
        <h2 class="section-title text-center mb-5">Instalações e Comodidades</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="amenity-card">
                    <i class="bi bi-wifi amenity-icon"></i>
                    <h5>Wi-Fi de Alta Velocidade</h5>
                    <p class="text-muted">Desfrute de acesso à internet sem fio de alta velocidade em todo o hotel.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="amenity-card">
                    <i class="bi bi-p-circle amenity-icon"></i>
                    <h5>Estacionamento</h5>
                    <p class="text-muted">Amplo e seguro espaço de estacionamento fornecido para todos os hóspedes do hotel.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="amenity-card">
                    <i class="bi bi-cup-hot amenity-icon"></i>
                    <h5>Restaurante e Bar</h5>
                    <p class="text-muted">Saboreie pratos gourmet e coquetéis em nosso elegante restaurante e bar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="amenity-card">
                    <i class="bi bi-flower1 amenity-icon"></i>
                    <h5>Centro de Spa</h5>
                    <p class="text-muted">Desfrute de uma variedade de tratamentos relaxantes e rejuvenescedores em nosso spa.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="amenity-card">
                    <i class="bi bi-activity amenity-icon"></i>
                    <h5>Centro de Fitness</h5>
                    <p class="text-muted">Mantenha-se ativo com equipamentos de fitness de última geração em nossa academia moderna.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="amenity-card">
                    <i class="bi bi-water amenity-icon"></i>
                    <h5>Piscina</h5>
                    <p class="text-muted">Refresque-se e relaxe em nossa piscina externa impecável.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
@if(isset($approvedReviews) && $approvedReviews->count() > 0)
<div class="container my-5 py-5">
    <h2 class="section-title text-center mb-5">O que nossos hóspedes dizem</h2>
    <div class="row g-4">
        @foreach($approvedReviews->take(3) as $review)
        <div class="col-md-4">
            <div class="review-card">
                <div class="mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }} stars"></i>
                    @endfor
                </div>
                <p class="fst-italic">"{{ Str::limit($review->comment, 120) }}"</p>
                <p class="mb-0"><strong>{{ $review->name }}</strong></p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection
