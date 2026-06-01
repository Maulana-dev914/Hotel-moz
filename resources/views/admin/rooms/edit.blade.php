@extends('layouts.admin')

@section('title', 'Editar Quarto - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Editar Quarto</h1>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.rooms.update', $room) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="number" class="form-label">Número do Quarto</label>
                <input type="text" class="form-control" id="number" name="number" value="{{ old('number', $room->number) }}" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="single" {{ old('type', $room->type) === 'single' ? 'selected' : '' }}>Solteiro</option>
                    <option value="double" {{ old('type', $room->type) === 'double' ? 'selected' : '' }}>Duplo</option>
                    <option value="matrimonial" {{ old('type', $room->type) === 'matrimonial' ? 'selected' : '' }}>Casal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Preço (MZN)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $room->price) }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available" {{ old('status', $room->status) === 'available' ? 'selected' : '' }}>Disponível</option>
                    <option value="occupied" {{ old('status', $room->status) === 'occupied' ? 'selected' : '' }}>Ocupado</option>
                    <option value="maintenance" {{ old('status', $room->status) === 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</div>
@endsection

