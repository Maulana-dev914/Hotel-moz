@extends('layouts.admin')

@section('title', 'Detalhes do Hóspede - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $guest->name }}</h1>
    <div>
        <a href="{{ route('admin.guests.edit', $guest) }}" class="btn btn-warning"><i class="bi bi-pencil"></i> Editar</a>
        <a href="{{ route('admin.guests.index') }}" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-sm-3">Nome:</dt>
            <dd class="col-sm-9">{{ $guest->name }}</dd>

            <dt class="col-sm-3">Documento:</dt>
            <dd class="col-sm-9">{{ $guest->document }}</dd>

            <dt class="col-sm-3">Telefone:</dt>
            <dd class="col-sm-9">{{ $guest->phone }}</dd>

            <dt class="col-sm-3">Email:</dt>
            <dd class="col-sm-9">{{ $guest->email }}</dd>
        </dl>
    </div>
</div>
@endsection

