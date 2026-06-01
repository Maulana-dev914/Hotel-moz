@extends('layouts.admin')

@section('title', 'Meu Perfil - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">Meu Perfil</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Informações da sua conta</p>
    </div>
    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil"></i> Editar Perfil
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Informações Pessoais</h5>
                
                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Nome:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->name }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Email:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->email }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Função:</strong>
                    </div>
                    <div class="col-sm-9">
                        @if($user->role === 'admin')
                            <span class="badge bg-danger">Administrador</span>
                        @else
                            <span class="badge bg-info">Gerente</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-3">
                        <strong>Membro desde:</strong>
                    </div>
                    <div class="col-sm-9">
                        {{ $user->created_at->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3" style="font-size: 4rem; color: var(--sidebar-bg);">
                    <i class="bi bi-person-circle"></i>
                </div>
                <h5>{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>
                <p>
                    @if($user->role === 'admin')
                        <span class="badge bg-danger">Administrador</span>
                    @else
                        <span class="badge bg-info">Gerente</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection


