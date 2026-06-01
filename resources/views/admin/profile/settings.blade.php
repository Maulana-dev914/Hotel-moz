@extends('layouts.admin')

@section('title', 'Definições - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">Definições</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Configurações da sua conta</p>
    </div>
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
                <h5 class="card-title mb-4">Configurações de Conta</h5>
                
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="role" class="form-label">Função</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="manager" {{ old('role', $user->role) === 'manager' ? 'selected' : '' }}>Gerente</option>
                        </select>
                        <small class="text-muted">A função determina as permissões de acesso no sistema.</small>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <button type="submit" class="btn btn-primary">Salvar Definições</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title mb-4">Informações do Sistema</h5>
                
                <div class="row mb-3">
                    <div class="col-sm-4">
                        <strong>Versão do Laravel:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ app()->version() }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-4">
                        <strong>Ambiente:</strong>
                    </div>
                    <div class="col-sm-8">
                        {{ app()->environment() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


