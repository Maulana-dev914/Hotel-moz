@extends('layouts.public')

@section('title', 'Quartos - Hotel Moz')

@section('content')
<div class="container my-5 py-5">
    <p class="section-subtitle text-center">EXQUISITO E LUXUOSO</p>
    <h2 class="section-title text-center mb-5">Nossa Coleção de Quartos</h2>

    <div class="row g-4">
        @forelse($rooms as $room)
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
                    <p class="text-muted mb-3">Quarto {{ $room->number }}</p>
                    <p class="card-text">Confortável e moderno, este quarto oferece comodidades essenciais para uma estadia confortável, perfeito para viajantes individuais ou casais em busca de relaxamento.</p>
                    
                    <div class="mt-3 mb-3">
                        <small class="text-muted d-block"><i class="bi bi-rulers"></i> Tamanho do quarto: 28 m²</small>
                        <small class="text-muted d-block"><i class="bi bi-bed"></i> 
                            @if($room->type === 'single') 1 Cama de Solteiro
                            @elseif($room->type === 'double') 2 Camas de Solteiro
                            @else 1 Cama de Casal
                            @endif
                        </small>
                        <small class="text-muted d-block"><i class="bi bi-people"></i> 
                            @if($room->type === 'single') 1 Adulto
                            @elseif($room->type === 'double') 2 Adultos
                            @else 2 Adultos - 1 Criança
                            @endif
                        </small>
                        <small class="text-muted d-block"><i class="bi bi-eye"></i> Vista para a rua</small>
                        <small class="text-muted d-block"><i class="bi bi-ban"></i> Fumar - NÃO</small>
                        <small class="text-muted d-block"><i class="bi bi-cup-hot"></i> Café da manhã - SIM</small>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('public.reservation.create', ['room_id' => $room->id]) }}" class="btn btn-gold">RESERVAR AGORA</a>
                        <a href="{{ route('public.availability.index') }}" class="btn btn-outline-dark">Verificar Disponibilidade</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <p class="mb-0">Nenhum quarto disponível no momento.</p>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

