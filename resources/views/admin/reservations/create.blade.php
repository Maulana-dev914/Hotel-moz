@extends('layouts.admin')

@section('title', 'Nova Reserva - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">Nova Reserva</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Criar nova reserva</p>
    </div>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">Voltar</a>
</div>

<div class="card-modern">
    <div class="card-body-modern">
        <form action="{{ route('admin.reservations.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="guest_id" class="form-label">Hóspede</label>
                <select class="form-select" id="guest_id" name="guest_id" required>
                    <option value="">Selecione...</option>
                    @foreach($guests as $guest)
                        <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>{{ $guest->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold">Selecione um ou mais quartos</label>
                <small class="text-muted d-block mb-2">Você pode selecionar múltiplos quartos para a mesma reserva</small>
                
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
                                            data-price="{{ $room->price }}"
                                            {{ old('room_ids') && in_array($room->id, old('room_ids')) ? 'checked' : '' }}>
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
                                                    <br>
                                                    <small class="text-muted">
                                                        Status: 
                                                        @if($room->status === 'available')
                                                            <span class="badge bg-success">Disponível</span>
                                                        @elseif($room->status === 'occupied')
                                                            <span class="badge bg-warning">Ocupado</span>
                                                        @else
                                                            <span class="badge bg-danger">Manutenção</span>
                                                        @endif
                                                    </small>
                                                </div>
                                                <div class="text-end">
                                                    <span style="color: var(--gold); font-weight: 600;">{{ number_format($room->price, 2, ',', '.') }} MZN</span>
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
                
                <div class="mt-3 p-3 bg-light rounded">
                    <strong>Total selecionado: <span id="total-price">0,00</span> MZN/noite</strong>
                    <br>
                    <small class="text-muted">Selecione os quartos acima para ver o total</small>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="check_in_date" class="form-label">Data de Check-in</label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" 
                        value="{{ old('check_in_date') }}" 
                        min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="check_out_date" class="form-label">Data de Check-out</label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" 
                        value="{{ old('check_out_date') }}" 
                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="pendente" {{ old('status') === 'pendente' ? 'selected' : '' }}>Pendente</option>
                    <option value="confirmada" {{ old('status') === 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="cancelada" {{ old('status') === 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Observações</label>
                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary" id="submit-btn">Salvar</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('check_in_date')?.addEventListener('change', function() {
        const checkIn = new Date(this.value);
        checkIn.setDate(checkIn.getDate() + 1);
        const minCheckOut = checkIn.toISOString().split('T')[0];
        const checkOutInput = document.getElementById('check_out_date');
        if (checkOutInput) {
            checkOutInput.setAttribute('min', minCheckOut);
            if (checkOutInput.value && checkOutInput.value < minCheckOut) {
                checkOutInput.value = minCheckOut;
            }
        }
    });

    // Calcular total quando quartos são selecionados
    document.querySelectorAll('.room-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateTotal();
            validateSelection();
        });
    });

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.room-checkbox:checked').forEach(checkbox => {
            total += parseFloat(checkbox.dataset.price);
        });
        document.getElementById('total-price').textContent = total.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function validateSelection() {
        const checked = document.querySelectorAll('.room-checkbox:checked').length;
        const submitBtn = document.getElementById('submit-btn');
        if (submitBtn) {
            if (checked === 0) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'SELECIONE PELO MENOS UM QUARTO';
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Salvar';
            }
        }
    }

    // Validar no carregamento
    document.addEventListener('DOMContentLoaded', function() {
        validateSelection();
        updateTotal();
    });
</script>
@endsection
