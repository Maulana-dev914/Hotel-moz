@extends('layouts.admin')

@section('title', 'Detalhes do Quarto - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quarto {{ $room->number }}</h1>
    <div>
        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Editar</a>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Número:</dt>
            <dd class="col-sm-9">{{ $room->number }}</dd>

            <dt class="col-sm-3">Tipo:</dt>
            <dd class="col-sm-9">
                @if($room->type === 'single') Solteiro
                @elseif($room->type === 'double') Duplo
                @else Casal
                @endif
            </dd>

            <dt class="col-sm-3">Preço:</dt>
            <dd class="col-sm-9">{{ number_format($room->price, 2, ',', '.') }} MZN</dd>

            <dt class="col-sm-3">Status:</dt>
            <dd class="col-sm-9">
                @if($room->status === 'available')
                    <span class="badge bg-success">Disponível</span>
                @elseif($room->status === 'occupied')
                    <span class="badge bg-warning">Ocupado</span>
                @else
                    <span class="badge bg-danger">Manutenção</span>
                @endif
            </dd>
        </dl>
    </div>
</div>
@endsection

