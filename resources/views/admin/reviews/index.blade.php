@extends('layouts.admin')

@section('title', 'Avaliações - Hotel Moz')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Avaliações</h1>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nota</th>
                    <th>Comentário</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
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
                        <td>
                            @if(!$review->approved)
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check"></i> Aprovar</button>
                                </form>
                            @else
                                <form action="{{ route('admin.reviews.disapprove', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning"><i class="bi bi-x"></i> Reprovar</button>
                                </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma avaliação cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $reviews->links() }}
    </div>
</div>
@endsection

