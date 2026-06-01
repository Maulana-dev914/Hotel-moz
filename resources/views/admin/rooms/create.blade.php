@extends('layouts.admin')

@section('title', 'Novo Quarto - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Novo Quarto</h1>
    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.rooms.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="number" class="form-label">Número do Quarto</label>
                <input type="text" class="form-control" id="number" name="number" value="{{ old('number') }}" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="">Selecione...</option>
                    <option value="single" {{ old('type') === 'single' ? 'selected' : '' }}>Solteiro</option>
                    <option value="double" {{ old('type') === 'double' ? 'selected' : '' }}>Duplo</option>
                    <option value="matrimonial" {{ old('type') === 'matrimonial' ? 'selected' : '' }}>Casal</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Preço (MZN)</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price') }}" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Disponível</option>
                    <option value="occupied" {{ old('status') === 'occupied' ? 'selected' : '' }}>Ocupado</option>
                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Manutenção</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
@endsection

