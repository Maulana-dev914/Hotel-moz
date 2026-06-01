@extends('layouts.public')

@section('title', 'Fazer Reserva - Hotel Moz')

@section('content')
<div class="container my-5 py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="section-title mb-4">Fazer Reserva</h2>

            @if($rooms && $rooms->count() > 0)
            <div class="card mb-4" style="border: 2px solid var(--gold);">
                <div class="card-body">
                    <h5 class="card-title">Quarto(s) Selecionado(s)</h5>
                    @foreach($rooms as $room)
                        <p class="mb-1">
                            <strong>Quarto {{ $room->number }}</strong> - 
                            @if($room->type === 'single') Solteiro
                            @elseif($room->type === 'double') Duplo
                            @else Casal
                            @endif
                            - <span class="room-price">{{ number_format($room->price, 2, ',', '.') }} MZN/noite</span>
                        </p>
                    @endforeach
                    @if($rooms->count() > 1)
                        <p class="mt-2 mb-0"><strong>Total: {{ number_format($rooms->sum('price'), 2, ',', '.') }} MZN/noite</strong></p>
                    @endif
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('public.reservation.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Selecione um ou mais quartos</label>
                            <small class="text-muted d-block mb-2">Você pode selecionar múltiplos quartos para a mesma reserva</small>
                            
                            @if($rooms && $rooms->count() > 0)
                                <div class="alert alert-info mb-3">
                                    <i class="bi bi-info-circle"></i> <strong>{{ $rooms->count() }} quarto(s) pré-selecionado(s)</strong> da busca de disponibilidade.
                                </div>
                                <div class="row g-3">
                                    @foreach($rooms as $room)
                                        <div class="col-md-6">
                                            <div class="card border" style="border-color: var(--gold) !important;">
                                                <div class="card-body">
                                                    <input type="hidden" name="room_ids[]" value="{{ $room->id }}">
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
                                                            <span class="room-price">{{ number_format($room->price, 2, ',', '.') }} MZN</span>
                                                            <br>
                                                            <small class="text-muted">por noite</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3 p-3 bg-light rounded">
                                    <strong>Total: {{ number_format($rooms->sum('price'), 2, ',', '.') }} MZN/noite</strong>
                                </div>
                            @else
                                <div class="row g-3">
                                    @foreach($availableRooms as $room)
                                        <div class="col-md-6">
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
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="room-price">{{ number_format($room->price, 2, ',', '.') }} MZN</span>
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
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="check_in_date" class="form-label">Data de Check-in</label>
                                <input type="date" class="form-control" id="check_in_date" name="check_in_date" 
                                    value="{{ old('check_in_date', $checkIn) }}" 
                                    min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="check_out_date" class="form-label">Data de Check-out</label>
                                <input type="date" class="form-control" id="check_out_date" name="check_out_date" 
                                    value="{{ old('check_out_date', $checkOut) }}" 
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="adults" class="form-label">Adultos</label>
                                <input type="number" class="form-control" id="adults" name="adults" 
                                    value="{{ old('adults', $adults ?? 1) }}" min="1" max="50" required>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="children" class="form-label">Crianças</label>
                                <input type="number" class="form-control" id="children" name="children" 
                                    value="{{ old('children', $children ?? 0) }}" min="0" max="50" required>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Tipo de Reserva</h5>
                        <div class="mb-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservation_type" id="reservation_type_person" 
                                    value="person" {{ old('reservation_type', 'person') === 'person' ? 'checked' : '' }} required
                                    onchange="toggleReservationType()">
                                <label class="form-check-label" for="reservation_type_person">
                                    Pessoa Física
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="reservation_type" id="reservation_type_company" 
                                    value="company" {{ old('reservation_type') === 'company' ? 'checked' : '' }} required
                                    onchange="toggleReservationType()">
                                <label class="form-check-label" for="reservation_type_company">
                                    Empresa
                                </label>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Formulário para Pessoa Física -->
                        <div id="person-form">
                            <h5 class="mb-3">Dados da Pessoa Física</h5>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="{{ old('name') }}" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Telefone (Moçambique)</label>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                        value="{{ old('phone') }}" placeholder="82 123 4567 ou +258 82 123 4567" required>
                                    <small class="text-muted">Ex: 82 123 4567, 83 123 4567, +258 82 123 4567</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="document_type" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="document_type" name="document_type" required onchange="updateDocumentPlaceholder()">
                                        <option value="">Selecione...</option>
                                        <option value="bi" {{ old('document_type') === 'bi' ? 'selected' : '' }}>B.I. (Bilhete de Identidade)</option>
                                        <option value="passport" {{ old('document_type') === 'passport' ? 'selected' : '' }}>Passaporte</option>
                                        <option value="driving_license" {{ old('document_type') === 'driving_license' ? 'selected' : '' }}>Carta de Condução</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="document" class="form-label">Número do Documento</label>
                                    <input type="text" class="form-control" id="document" name="document" 
                                        value="{{ old('document') }}" placeholder="Digite o número do documento" required>
                                    <small class="text-muted" id="document-hint"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Formulário para Empresa -->
                        <div id="company-form" style="display: none;">
                            <h5 class="mb-3">Dados da Empresa</h5>

                            <div class="mb-3">
                                <label for="company_name" class="form-label">Razão Social</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" 
                                    value="{{ old('company_name') }}">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="company_email" name="company_email" 
                                        value="{{ old('company_email') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_phone" class="form-label">Telefone (Moçambique)</label>
                                    <input type="text" class="form-control" id="company_phone" name="company_phone" 
                                        value="{{ old('company_phone') }}" placeholder="82 123 4567 ou +258 82 123 4567">
                                    <small class="text-muted">Ex: 82 123 4567, 83 123 4567, +258 82 123 4567</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="company_document_type" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="company_document_type" name="company_document_type" onchange="updateCompanyDocumentPlaceholder()">
                                        <option value="">Selecione...</option>
                                        <option value="nuit" {{ old('company_document_type') === 'nuit' ? 'selected' : '' }}>NUIT (Número Único de Identificação Tributária)</option>
                                        <option value="company_registration" {{ old('company_document_type') === 'company_registration' ? 'selected' : '' }}>Registo de Empresa</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="company_document" class="form-label">Número do Documento</label>
                                    <input type="text" class="form-control" id="company_document" name="company_document" 
                                        value="{{ old('company_document') }}" placeholder="Digite o número do documento">
                                    <small class="text-muted" id="company-document-hint"></small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contact_person" class="form-label">Nome do Contacto</label>
                                <input type="text" class="form-control" id="contact_person" name="contact_person" 
                                    value="{{ old('contact_person') }}" placeholder="Nome da pessoa responsável">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Observações (Opcional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                placeholder="Alguma observação especial?">{{ old('notes') }}</textarea>
                        </div>

                        <div class="alert alert-info">
                            <small><i class="bi bi-info-circle"></i> Sua reserva será analisada e você receberá uma confirmação por email.</small>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-gold btn-lg" id="submit-btn" 
                                @if($rooms && $rooms->count() > 0) 
                                    style="display: block !important;"
                                @endif
                                onclick="return validateForm()">
                                CONFIRMAR RESERVA
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        const hiddenRooms = document.querySelectorAll('input[name="room_ids[]"][type="hidden"]').length;
        const submitBtn = document.getElementById('submit-btn');
        
        if (submitBtn) {
            // Se há quartos pré-selecionados (hidden) ou checkboxes selecionados, habilitar botão
            if (hiddenRooms > 0 || checked > 0) {
                submitBtn.disabled = false;
                submitBtn.textContent = 'CONFIRMAR RESERVA';
                submitBtn.style.display = 'block';
                submitBtn.style.visibility = 'visible';
            } else if (checked === 0 && hiddenRooms === 0) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'SELECIONE PELO MENOS UM QUARTO';
            } else {
                submitBtn.disabled = false;
                submitBtn.textContent = 'CONFIRMAR RESERVA';
                submitBtn.style.display = 'block';
                submitBtn.style.visibility = 'visible';
            }
        }
    }

    // Toggle entre formulário de pessoa física e empresa
    function toggleReservationType() {
        const personType = document.getElementById('reservation_type_person');
        const companyType = document.getElementById('reservation_type_company');
        const personForm = document.getElementById('person-form');
        const companyForm = document.getElementById('company-form');
        
        if (personType.checked) {
            personForm.style.display = 'block';
            companyForm.style.display = 'none';
            // Tornar campos de pessoa obrigatórios
            document.getElementById('name').required = true;
            document.getElementById('email').required = true;
            document.getElementById('phone').required = true;
            document.getElementById('document_type').required = true;
            document.getElementById('document').required = true;
            // Remover obrigatoriedade dos campos de empresa
            if (document.getElementById('company_name')) {
                document.getElementById('company_name').required = false;
                document.getElementById('company_email').required = false;
                document.getElementById('company_phone').required = false;
            }
        } else if (companyType.checked) {
            personForm.style.display = 'none';
            companyForm.style.display = 'block';
            // Remover obrigatoriedade dos campos de pessoa
            document.getElementById('name').required = false;
            document.getElementById('email').required = false;
            document.getElementById('phone').required = false;
            document.getElementById('document_type').required = false;
            document.getElementById('document').required = false;
            // Tornar campos de empresa obrigatórios
            if (document.getElementById('company_name')) {
                document.getElementById('company_name').required = true;
                document.getElementById('company_email').required = true;
                document.getElementById('company_phone').required = true;
            }
        }
    }

    function validateForm() {
        const personType = document.getElementById('reservation_type_person');
        if (personType.checked) {
            if (!document.getElementById('name').value || !document.getElementById('email').value || 
                !document.getElementById('phone').value || !document.getElementById('document_type').value || 
                !document.getElementById('document').value) {
                alert('Por favor, preencha todos os campos obrigatórios para Pessoa Física.');
                return false;
            }
        } else {
            if (!document.getElementById('company_name').value || !document.getElementById('company_email').value || 
                !document.getElementById('company_phone').value) {
                alert('Por favor, preencha todos os campos obrigatórios para Empresa.');
                return false;
            }
        }
        return true;
    }

    function updateDocumentPlaceholder() {
        const docType = document.getElementById('document_type').value;
        const docInput = document.getElementById('document');
        const hint = document.getElementById('document-hint');
        
        const hints = {
            'bi': 'B.I. deve ter entre 7 e 13 caracteres (ex: 123456789A)',
            'passport': 'Passaporte deve ter entre 7 e 10 caracteres (ex: A123456)',
            'driving_license': 'Carta de Condução deve ter entre 6 e 12 caracteres'
        };
        
        hint.textContent = hints[docType] || '';
    }

    function updateCompanyDocumentPlaceholder() {
        const docType = document.getElementById('company_document_type').value;
        const hint = document.getElementById('company-document-hint');
        
        const hints = {
            'nuit': 'NUIT deve ter exatamente 9 dígitos',
            'company_registration': 'Registo de Empresa deve ter entre 6 e 15 caracteres'
        };
        
        hint.textContent = hints[docType] || '';
    }

    // Validar no carregamento
    document.addEventListener('DOMContentLoaded', function() {
        // Se há quartos pré-selecionados, garantir que o botão esteja habilitado
        const hiddenRooms = document.querySelectorAll('input[name="room_ids[]"][type="hidden"]').length;
        const submitBtn = document.getElementById('submit-btn');
        
        if (hiddenRooms > 0 && submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.display = 'block';
            submitBtn.style.visibility = 'visible';
            submitBtn.textContent = 'CONFIRMAR RESERVA';
        }
        
        validateSelection();
        updateTotal();
        toggleReservationType(); // Inicializar formulário correto
    });
</script>
@endsection
