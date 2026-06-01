@extends('layouts.public')

@section('title', 'Disponibilidade - Hotel Moz')

@section('content')
<div class="container my-5 py-5">
    <div class="row">
        <div class="col-md-12 text-center mb-5">
            <p class="section-subtitle">VERIFIQUE A DISPONIBILIDADE</p>
            <h2 class="section-title">Quartos Disponíveis</h2>
            <p class="lead">Consulte os quartos disponíveis para suas datas</p>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('public.availability.search') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="check_in_date" class="form-label"><i class="bi bi-calendar-check"></i> Data de Entrada</label>
                                <input type="date" class="form-control form-control-lg" id="check_in_date" name="check_in_date" 
                                    value="{{ old('check_in_date', request('check_in_date')) }}" 
                                    min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="check_out_date" class="form-label"><i class="bi bi-calendar-x"></i> Data de Saída</label>
                                <input type="date" class="form-control form-control-lg" id="check_out_date" name="check_out_date" 
                                    value="{{ old('check_out_date', request('check_out_date')) }}" 
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="adults" class="form-label"><i class="bi bi-people"></i> Adultos</label>
                                <input type="number" class="form-control form-control-lg" id="adults" name="adults" 
                                    value="{{ old('adults', request('adults', 1)) }}" min="1" max="20" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="children" class="form-label"><i class="bi bi-person-heart"></i> Crianças</label>
                                <input type="number" class="form-control form-control-lg" id="children" name="children" 
                                    value="{{ old('children', request('children', 0)) }}" min="0" max="20" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-gold btn-lg px-5"><i class="bi bi-search"></i> Buscar Quartos Disponíveis</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($availableRooms))
        <div class="row">
            <div class="col-12 mb-4">
                @if($availableRooms->count() > 0)
                    <h4 class="mb-3">Período: {{ \Carbon\Carbon::parse($checkIn)->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($checkOut)->format('d/m/Y') }}</h4>
                    <p class="text-muted">
                        <strong>{{ $adults ?? 1 }} adulto(s)</strong> e <strong>{{ $children ?? 0 }} criança(s)</strong> 
                        - {{ $availableRooms->count() }} quarto(s) disponível(eis)
                    </p>
                    @if(isset($suggestedRooms) && $suggestedRooms->count() > 0)
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> 
                            <strong>{{ $suggestedRooms->count() }} quarto(s) recomendado(s)</strong> para o seu grupo de {{ $totalGuests ?? 1 }} pessoa(s)
                        </div>
                    @endif
                @endif
            </div>
        </div>

        @if($availableRooms->count() > 0)
            @if(isset($suggestedRooms) && $suggestedRooms->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <h5 class="mb-3"><i class="bi bi-star-fill text-warning"></i> Quartos Recomendados para Você</h5>
                    </div>
                </div>
            @endif
            <div class="row g-4">
                @foreach($availableRooms as $room)
                @php
                    $isSuggested = isset($suggestedRooms) && $suggestedRooms->contains('id', $room->id);
                @endphp
                <div class="col-md-4">
                    <div class="room-card card {{ $isSuggested ? 'border-success border-2' : '' }}" 
                         style="{{ $isSuggested ? 'box-shadow: 0 0 10px rgba(25, 135, 84, 0.3);' : '' }}">
                        @if($isSuggested)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success"><i class="bi bi-star-fill"></i> Recomendado</span>
                            </div>
                        @endif
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
                            <p class="card-text">Confortável e moderno, este quarto oferece comodidades essenciais para uma estadia confortável.</p>
                            
                            <div class="mt-3 mb-3">
                                <small class="text-muted d-block"><i class="bi bi-rulers"></i> 28 m²</small>
                                <small class="text-muted d-block"><i class="bi bi-bed"></i> 
                                    @if($room->type === 'single') 1 Cama de Solteiro
                                    @elseif($room->type === 'double') 2 Camas de Solteiro
                                    @else 1 Cama de Casal
                                    @endif
                                </small>
                                <small class="text-muted d-block"><i class="bi bi-people"></i> 
                                    Capacidade: {{ $room->max_adults ?? 2 }} adulto(s) 
                                    @if(($room->max_children ?? 0) > 0)
                                        e {{ $room->max_children }} criança(s)
                                    @endif
                                </small>
                            </div>

                            <div class="d-grid gap-2">
                                <div class="form-check mb-2">
                                    <input class="form-check-input room-select-checkbox" type="checkbox" 
                                        value="{{ $room->id }}" 
                                        id="select_room_{{ $room->id }}"
                                        data-price="{{ $room->price }}"
                                        data-adults="{{ $room->max_adults ?? 2 }}"
                                        data-children="{{ $room->max_children ?? 0 }}">
                                    <label class="form-check-label" for="select_room_{{ $room->id }}">
                                        Selecionar para reserva
                                    </label>
                                </div>
                                <a href="{{ route('public.reservation.create', [
                                    'room_ids' => $room->id, 
                                    'check_in_date' => $checkIn, 
                                    'check_out_date' => $checkOut,
                                    'adults' => $adults ?? 1,
                                    'children' => $children ?? 0
                                ]) }}" 
                                   class="btn btn-gold btn-sm">RESERVAR ESTE</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
                        <h5 class="mt-3">Nenhum quarto disponível</h5>
                        <p class="mb-0">Não há quartos disponíveis para o período selecionado. Tente outras datas.</p>
                        <a href="{{ route('public.rooms.index') }}" class="btn btn-outline-dark mt-3">Ver Todos os Quartos</a>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($availableRooms) && $availableRooms->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card-modern">
                        <div class="card-body-modern">
                            <h5>Reservar Múltiplos Quartos</h5>
                            <p class="text-muted">Selecione os quartos acima e clique no botão abaixo para reservar todos de uma vez.</p>
                            <form id="multi-reservation-form" action="{{ route('public.reservation.create') }}" method="GET">
                                <input type="hidden" name="check_in_date" value="{{ $checkIn }}">
                                <input type="hidden" name="check_out_date" value="{{ $checkOut }}">
                                <input type="hidden" name="adults" value="{{ $adults ?? 1 }}">
                                <input type="hidden" name="children" value="{{ $children ?? 0 }}">
                                <input type="hidden" name="room_ids" id="selected-room-ids" value="">
                                <button type="submit" class="btn btn-gold" id="reserve-multiple-btn" disabled>
                                    RESERVAR QUARTOS SELECIONADOS (<span id="selected-count">0</span>)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif
</div>

<script>
    document.getElementById('check_in_date')?.addEventListener('change', function() {
        const checkIn = new Date(this.value);
        checkIn.setDate(checkIn.getDate() + 1);
        const minCheckOut = checkIn.toISOString().split('T')[0];
        const checkOutInput = document.getElementById('check_out_date');
        if (checkOutInput) {
            checkOutInput.setAttribute('min', minCheckOut);
            if (checkOutInput.value && checkOutInput.value < minCheckOut) {
                checkOutInput.value = minCheckOut;
            }
        }
    });

    // Gerenciar seleção múltipla de quartos
    document.querySelectorAll('.room-select-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedRooms();
        });
    });

    function updateSelectedRooms() {
        const selected = Array.from(document.querySelectorAll('.room-select-checkbox:checked'))
            .map(cb => cb.value);
        
        document.getElementById('selected-room-ids').value = selected.join(',');
        document.getElementById('selected-count').textContent = selected.length;
        
        const btn = document.getElementById('reserve-multiple-btn');
        if (selected.length > 0) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }
</script>
@endsection
