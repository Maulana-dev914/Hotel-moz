@extends('layouts.admin')

@section('title', 'Detalhes da Reserva - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Reserva #{{ $reservation->id }}</h1>
    <div>
        <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Editar</a>
        <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Hóspede:</dt>
            <dd class="col-sm-9">{{ $reservation->guest->name }}</dd>

            <dt class="col-sm-3">Quarto(s):</dt>
            <dd class="col-sm-9">
                @php
                    $allRooms = $reservation->rooms->count() > 0 ? $reservation->rooms : collect([$reservation->room]);
                @endphp
                @foreach($allRooms as $room)
                    <span class="badge bg-primary me-1 mb-1">
                        Quarto {{ $room->number }} 
                        (@if($room->type === 'single') Solteiro
                        @elseif($room->type === 'double') Duplo
                        @else Casal
                        @endif)
                    </span>
                @endforeach
                @if($allRooms->count() > 1)
                    <p class="mt-2 mb-0"><strong>Total: {{ $allRooms->count() }} quartos</strong></p>
                @endif
            </dd>

            <dt class="col-sm-3">Check-in:</dt>
            <dd class="col-sm-9">{{ $reservation->check_in_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Check-out:</dt>
            <dd class="col-sm-9">{{ $reservation->check_out_date->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9">
                @if($reservation->status === 'pendente')
                    <span class="badge bg-warning">Pendente</span>
                @elseif($reservation->status === 'confirmada')
                    <span class="badge bg-success">Confirmada</span>
                @else
                    <span class="badge bg-danger">Cancelada</span>
                @endif
            </dd>

            @if($reservation->notes)
                <dt class="col-sm-3">Observações:</dt>
                <dd class="col-sm-9">{{ $reservation->notes }}</dd>
            @endif
        </dl>

        @if($reservation->status === 'confirmada' && !$reservation->stay)
            <div class="mt-3">
                <a href="{{ route('admin.stays.create') }}?reservation_id={{ $reservation->id }}" class="btn btn-success">Fazer Check-in</a>
            </div>
        @endif
    </div>
</div>
@endsection

