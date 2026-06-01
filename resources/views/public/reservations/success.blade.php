@extends('layouts.public')

@section('title', 'Reserva Confirmada - Hotel Moz')

@section('content')
<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="mb-4">
                <i class="bi bi-check-circle-fill" style="font-size: 5rem; color: var(--gold);"></i>
            </div>
            <h2 class="section-title">Reserva Enviada com Sucesso!</h2>
            <p class="lead">Obrigado por escolher o Hotel Moz!</p>
            <p>Sua solicitação de reserva foi enviada e será analisada pela nossa equipe. Você receberá uma confirmação por email em breve.</p>
            
            <div class="mt-4">
                <a href="{{ route('public.home') }}" class="btn btn-gold me-2">Voltar ao Início</a>
                <a href="{{ route('public.rooms.index') }}" class="btn btn-outline-dark">Ver Outros Quartos</a>
            </div>
        </div>
    </div>
</div>
@endsection

