@extends('layouts.admin')

@section('title', 'Quartos - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Quartos</h1>
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Novo Quarto</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Tipo</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                    <tr>
                        <td>{{ $room->number }}</td>
                        <td>
                            @if($room->type === 'single') Solteiro
                            @elseif($room->type === 'double') Duplo
                            @else Casal
                            @endif
                        </td>
                        <td>{{ number_format($room->price, 2, ',', '.') }} MZN</td>
                        <td>
                            @if($room->status === 'available')
                                <span class="badge bg-success">Disponível</span>
                            @elseif($room->status === 'occupied')
                                <span class="badge bg-warning">Ocupado</span>
                            @else
                                <span class="badge bg-danger">Manutenção</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhum quarto cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $rooms->links() }}
    </div>
</div>
@endsection

