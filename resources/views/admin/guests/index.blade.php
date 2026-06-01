@extends('layouts.admin')

@section('title', 'Hóspedes - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Hóspedes</h1>
    <a href="{{ route('admin.guests.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Novo Hóspede</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Documento</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    <tr>
                        <td>{{ $guest->name }}</td>
                        <td>{{ $guest->document }}</td>
                        <td>{{ $guest->phone }}</td>
                        <td>{{ $guest->email }}</td>
                        <td>
                            <a href="{{ route('admin.guests.show', $guest) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.guests.edit', $guest) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.guests.destroy', $guest) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Nenhum hóspede cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $guests->links() }}
    </div>
</div>
@endsection

