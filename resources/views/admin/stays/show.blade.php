@extends('layouts.admin')

@section('title', 'Detalhes da Estadia - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Estadia #{{ $stay->id }}</h1>
    <div>
        @if($stay->status === 'active')
            <form action="{{ route('admin.stays.checkout', $stay) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmar check-out?')">
                @csrf
                <button type="submit" class="btn btn-warning"><i class="bi bi-box-arrow-right"></i> Check-out</button>
            </form>
        @endif
        <a href="{{ route('admin.stays.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Hóspede:</dt>
            <dd class="col-sm-9">{{ $stay->guest->name }}</dd>

            <dt class="col-sm-3">Quarto:</dt>
            <dd class="col-sm-9">{{ $stay->room->number }}</dd>

            <dt class="col-sm-3">Check-in:</dt>
            <dd class="col-sm-9">{{ $stay->check_in_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Check-out Esperado:</dt>
            <dd class="col-sm-9">{{ $stay->expected_check_out_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Check-out Real:</dt>
            <dd class="col-sm-9">{{ $stay->actual_check_out_at ? $stay->actual_check_out_at->format('d/m/Y H:i') : 'Ainda não realizado' }}</dd>

            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9">
                @if($stay->status === 'active')
                    <span class="badge bg-success">Ativa</span>
                @else
                    <span class="badge bg-secondary">Finalizada</span>
                @endif
            </dd>

            @if($stay->reservation)
                <dt class="col-sm-3">Reserva:</dt>
                <dd class="col-sm-9"><a href="{{ route('admin.reservations.show', $stay->reservation) }}">Ver Reserva #{{ $stay->reservation->id }}</a></dd>
            @endif

            @if($stay->notes)
                <dt class="col-sm-3">Observações:</dt>
                <dd class="col-sm-9">{{ $stay->notes }}</dd>
            @endif
        </dl>
    </div>
</div>
@endsection

