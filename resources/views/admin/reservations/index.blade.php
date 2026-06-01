@extends('layouts.admin')

@section('title', 'Reservas - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Reservas</h1>
    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nova Reserva</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hóspede</th>
                    <th>Quarto</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->guest->name }}</td>
                        <td>
                            @php
                                $allRooms = $reservation->rooms->count() > 0 ? $reservation->rooms : collect([$reservation->room]);
                            @endphp
                            @foreach($allRooms as $room)
                                <span class="badge bg-secondary me-1">Quarto {{ $room->number }}</span>
                            @endforeach
                            @if($allRooms->count() > 1)
                                <small class="text-muted d-block">({{ $allRooms->count() }} quartos)</small>
                            @endif
                        </td>
                        <td>{{ $reservation->check_in_date->format('d/m/Y') }}</td>
                        <td>{{ $reservation->check_out_date->format('d/m/Y') }}</td>
                        <td>
                            @if($reservation->status === 'pendente')
                                <span class="badge bg-warning">Pendente</span>
                            @elseif($reservation->status === 'confirmada')
                                <span class="badge bg-success">Confirmada</span>
                            @else
                                <span class="badge bg-danger">Cancelada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.reservations.show', $reservation) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.reservations.destroy', $reservation) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma reserva cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $reservations->links() }}
    </div>
</div>
@endsection

