@extends('layouts.admin')

@section('title', 'Dashboard - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-0" style="font-weight: 700; color: var(--text-primary);">Dashboard</h2>
        <p class="text-muted mb-0" style="font-size: 0.9rem;">Visão geral do Hotel Moz</p>
    </div>
    <div>
        <span class="text-muted" style="font-size: 0.9rem;">{{ date('Y') }}</span>
    </div>
</div>

<!-- KPI Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-success">
                <i class="bi bi-door-open"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--success);">{{ $availableRooms }}</h3>
            <p class="kpi-label">Quartos Disponíveis</p>
            <small class="text-muted">Total: {{ $totalRooms }} quartos</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-warning">
                <i class="bi bi-door-closed"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--warning);">{{ $occupiedRooms }}</h3>
            <p class="kpi-label">Quartos Ocupados</p>
            <small class="text-muted">{{ $activeStays }} estadias ativas</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-info">
                <i class="bi bi-calendar-check"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--info);">{{ $pendingReservations }}</h3>
            <p class="kpi-label">Reservas Pendentes</p>
            <small class="text-muted">{{ $totalReservations }} total de reservas</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon" style="background-color: #e0e7ff; color: #6366f1;">
                <i class="bi bi-calendar-event"></i>
            </div>
            <h3 class="kpi-value" style="color: #6366f1;">{{ $reservedRoomsCount ?? 0 }}</h3>
            <p class="kpi-label">Quartos Reservados</p>
            <small class="text-muted">No período atual</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-danger">
                <i class="bi bi-tools"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--danger);">{{ $maintenanceRooms }}</h3>
            <p class="kpi-label">Em Manutenção</p>
            <small class="text-muted">Quartos indisponíveis</small>
        </div>
    </div>
</div>

<!-- Second Row KPI -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-info">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--info);">{{ $totalGuests }}</h3>
            <p class="kpi-label">Total de Hóspedes</p>
            <small class="text-muted">{{ $activeStays }} hospedados agora</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--success);">{{ $confirmedReservations }}</h3>
            <p class="kpi-label">Reservas Confirmadas</p>
            <small class="text-muted">Prontas para check-in</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-warning">
                <i class="bi bi-star"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--warning);">{{ $pendingReviews }}</h3>
            <p class="kpi-label">Avaliações Pendentes</p>
            <small class="text-muted">{{ $totalReviews }} total de avaliações</small>
        </div>
    </div>
    <div class="col-md-3">
        <div class="kpi-card">
            <div class="kpi-icon kpi-success">
                <i class="bi bi-house-check"></i>
            </div>
            <h3 class="kpi-value" style="color: var(--success);">{{ $completedStays }}</h3>
            <p class="kpi-label">Estadias Finalizadas</p>
            <small class="text-muted">Este mês</small>
        </div>
    </div>
</div>

<!-- Charts and Tables Row -->
<div class="row g-4">
    <!-- Recent Reservations -->
    <div class="col-md-6">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5><i class="bi bi-calendar-event"></i> Reservas Recentes</h5>
            </div>
            <div class="card-body-modern">
                @if($recentReservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Hóspede</th>
                                    <th>Quarto</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->guest->name }}</td>
                                        <td>
                                            @php
                                                $allRooms = $reservation->rooms->count() > 0 ? $reservation->rooms : collect([$reservation->room]);
                                            @endphp
                                            @foreach($allRooms as $room)
                                                <span class="badge bg-secondary me-1">Quarto {{ $room->number }}</span>
                                            @endforeach
                                            @if($allRooms->count() > 1)
                                                <small class="text-muted d-block">({{ $allRooms->count() }} quartos)</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($reservation->status === 'pendente')
                                                <span class="badge bg-warning">Pendente</span>
                                            @elseif($reservation->status === 'confirmada')
                                                <span class="badge bg-success">Confirmada</span>
                                            @else
                                                <span class="badge bg-danger">Cancelada</span>
                                            @endif
                                        </td>
                                        <td>{{ $reservation->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.reservations.index') }}" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                @else
                    <p class="text-muted text-center">Nenhuma reserva recente.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Stays -->
    <div class="col-md-6">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5><i class="bi bi-house-door"></i> Estadias Ativas</h5>
            </div>
            <div class="card-body-modern">
                @if($recentStays->where('status', 'active')->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Hóspede</th>
                                    <th>Quarto</th>
                                    <th>Check-in</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStays->where('status', 'active') as $stay)
                                    <tr>
                                        <td>{{ $stay->guest->name }}</td>
                                        <td>{{ $stay->room->number }}</td>
                                        <td>{{ $stay->check_in_at->format('d/m/Y') }}</td>
                                        <td><span class="badge bg-success">Ativa</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.stays.index') }}" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                @else
                    <p class="text-muted text-center">Nenhuma estadia ativa no momento.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card-modern">
            <div class="card-header-modern">
                <h5><i class="bi bi-star"></i> Últimas Avaliações</h5>
            </div>
            <div class="card-body-modern">
                @if($recentReviews->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Nota</th>
                                    <th>Comentário</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentReviews as $review)
                                    <tr>
                                        <td>{{ $review->name }}</td>
                                        <td>{{ $review->email }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-muted"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td>{{ Str::limit($review->comment, 50) }}</td>
                                        <td>
                                            @if($review->approved)
                                                <span class="badge bg-success">Aprovada</span>
                                            @else
                                                <span class="badge bg-warning">Pendente</span>
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-primary">Ver Todas</a>
                    </div>
                @else
                    <p class="text-muted text-center">Nenhuma avaliação ainda.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
