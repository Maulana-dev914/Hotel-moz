@extends('layouts.admin')

@section('title', 'Nova Estadia - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nova Estadia (Check-in)</h1>
    <a href="{{ route('admin.stays.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card">
    <div class="card-body">
        @if($reservation)
            <div class="alert alert-info">
                <strong>Check-in a partir de reserva:</strong> Os dados serão preenchidos automaticamente.
            </div>
        @endif

        <form action="{{ route('admin.stays.store') }}" method="POST">
            @csrf
            @if($reservation)
                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                <div class="mb-3">
                    <label class="form-label">Hóspede</label>
                    <input type="text" class="form-control" value="{{ $reservation->guest->name }}" readonly>
                    <input type="hidden" name="guest_id" value="{{ $reservation->guest_id }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Quarto(s) da Reserva</label>
                    <div class="alert alert-info">
                        <strong>Quartos reservados:</strong><br>
                        @if($reservation->rooms->count() > 0)
                            @foreach($reservation->rooms as $room)
                                <input type="checkbox" name="room_ids[]" value="{{ $room->id }}" id="res_room_{{ $room->id }}" checked>
                                <label for="res_room_{{ $room->id }}">Quarto {{ $room->number }}</label><br>
                            @endforeach
                        @else
                            <input type="checkbox" name="room_ids[]" value="{{ $reservation->room_id }}" id="res_room_{{ $reservation->room_id }}" checked>
                            <label for="res_room_{{ $reservation->room_id }}">Quarto {{ $reservation->room->number }}</label>
                        @endif
                    </div>
                </div>
            @else
                <div class="mb-3">
                    <label for="guest_id" class="form-label">Hóspede</label>
                    <select class="form-select" id="guest_id" name="guest_id" required>
                        <option value="">Selecione...</option>
                        @foreach($guests as $guest)
                            <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>{{ $guest->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="mb-3">
                <label class="form-label fw-bold">Selecione um ou mais quartos</label>
                <small class="text-muted d-block mb-2">Você pode selecionar múltiplos quartos para o check-in</small>
                <div class="row g-3">
                    @foreach($rooms as $room)
                        <div class="col-md-4">
                            <div class="card border">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input room-checkbox" type="checkbox" 
                                            name="room_ids[]" 
                                            value="{{ $room->id }}" 
                                            id="room_{{ $room->id }}"
                                            {{ old('room_ids') && in_array($room->id, old('room_ids')) ? 'checked' : '' }}
                                            {{ $reservation && $reservation->rooms->contains('id', $room->id) ? 'checked' : '' }}>
                                        <label class="form-check-label w-100" for="room_{{ $room->id }}">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <strong>Quarto {{ $room->number }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        @if($room->type === 'single') Solteiro
                                                        @elseif($room->type === 'double') Duplo
                                                        @else Casal
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <span class="text-muted">{{ number_format($room->price, 2, ',', '.') }} MZN</span>
                                                    <br>
                                                    <small class="text-muted">por noite</small>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <label for="check_in_at" class="form-label">Data/Hora de Check-in</label>
                <input type="datetime-local" class="form-control" id="check_in_at" name="check_in_at" value="{{ old('check_in_at', now()->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="mb-3">
                <label for="expected_check_out_at" class="form-label">Data/Hora de Check-out Esperado</label>
                <input type="datetime-local" class="form-control" id="expected_check_out_at" name="expected_check_out_at" value="{{ old('expected_check_out_at') }}" required>
            </div>
            <div class="mb-3">
                <label for="notes" class="form-label">Observações</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Realizar Check-in</button>
        </form>
    </div>
</div>
@endsection

