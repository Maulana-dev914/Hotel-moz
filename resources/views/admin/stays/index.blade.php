@extends('layouts.admin')

@section('title', 'Estadias - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Estadias</h1>
    <a href="{{ route('admin.stays.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Nova Estadia (Check-in)</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hóspede</th>
                    <th>Quarto</th>
                    <th>Check-in</th>
                    <th>Check-out Esperado</th>
                    <th>Check-out Real</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stays as $stay)
                    <tr>
                        <td>{{ $stay->guest->name }}</td>
                        <td>{{ $stay->room->number }}</td>
                        <td>{{ $stay->check_in_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $stay->expected_check_out_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $stay->actual_check_out_at ? $stay->actual_check_out_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>
                            @if($stay->status === 'active')
                                <span class="badge bg-success">Ativa</span>
                            @else
                                <span class="badge bg-secondary">Finalizada</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.stays.show', $stay) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            @if($stay->status === 'active')
                                <form action="{{ route('admin.stays.checkout', $stay) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirmar check-out?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning"><i class="bi bi-box-arrow-right"></i> Check-out</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.stays.destroy', $stay) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma estadia cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $stays->links() }}
    </div>
</div>
@endsection

