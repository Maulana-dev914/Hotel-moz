@extends('layouts.admin')

@section('title', 'Detalhes do Usuário - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">{{ $user->name }}</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Detalhes do usuário</p>
    </div>
    <div>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Editar</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card-modern">
    <div class="card-body-modern">
        <dl class="row">
            <dt class="col-sm-3">Nome:</dt>
            <dd class="col-sm-9">{{ $user->name }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>

            <dt class="col-sm-3">Data de Criação:</dt>
            <dd class="col-sm-9">{{ $user->created_at->format('d/m/Y H:i') }}</dd>

            <dt class="col-sm-3">Última Atualização:</dt>
            <dd class="col-sm-9">{{ $user->updated_at->format('d/m/Y H:i') }}</dd>
        </dl>
    </div>
</div>
@endsection

