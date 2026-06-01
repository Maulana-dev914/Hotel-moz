@extends('layouts.admin')

@section('title', 'Editar Usuário - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">Editar Usuário</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Atualizar dados do usuário</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card-modern">
    <div class="card-body-modern">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                <input type="password" class="form-control" id="password" name="password">
                <small class="text-muted">Mínimo de 6 caracteres</small>
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>
</div>
@endsection

