<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hotel Moz')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #D4AF37;
            --bronze: #CD7F32;
            --dark-brown: #8B4513;
            --cream: #F5F5DC;
            --dark: #1a1a1a;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-brown) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark) !important;
            margin: 0 0.5rem;
            transition: color 0.3s;
        }

        .nav-link:hover {
            color: var(--gold) !important;
        }

        .btn-gold {
            background-color: var(--gold);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-gold:hover {
            background-color: var(--bronze);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.4);
        }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1200') center/cover;
            min-height: 600px;
            display: flex;
            align-items: center;
            color: white;
            position: relative;
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 1.5rem;
        }

        .hero-section .lead {
            font-size: 1.3rem;
            margin-bottom: 2rem;
        }

        .section-title {
            color: var(--dark-brown);
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--bronze);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
        }

        .feature-card {
            text-align: center;
            padding: 2rem;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .room-card {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
            height: 100%;
        }

        .room-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .room-card img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        .room-price {
            color: var(--gold);
            font-size: 1.5rem;
            font-weight: 700;
        }

        .amenity-card {
            padding: 2rem;
            text-align: center;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            transition: all 0.3s;
            height: 100%;
        }

        .amenity-card:hover {
            border-color: var(--gold);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.2);
        }

        .amenity-icon {
            font-size: 2.5rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 50px 0 20px;
            margin-top: 80px;
        }

        footer a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: var(--gold);
        }

        .review-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 100%;
        }

        .stars {
            color: var(--gold);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('public.home') }}">Hotel Moz</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.home') }}">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.rooms.index') }}">Quartos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.availability.index') }}">Disponibilidade</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.review.create') }}">Avaliar</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-gold" href="{{ route('admin.login') }}"><i class="bi bi-gear"></i> Administração</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 76px;">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3" style="color: var(--gold);">Hotel Moz</h5>
                    <p>Seu conforto é nossa prioridade. Desfrute de uma estadia inesquecível conosco.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3" style="color: var(--gold);">Contato</h5>
                    <p><i class="bi bi-telephone"></i> (00) 0000-0000</p>
                    <p><i class="bi bi-envelope"></i> contato@hotelmoz.com</p>
                    <p><i class="bi bi-geo-alt"></i> Centro da Cidade</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3" style="color: var(--gold);">Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('public.home') }}">Início</a></li>
                        <li><a href="{{ route('public.rooms.index') }}">Quartos</a></li>
                        <li><a href="{{ route('public.availability.index') }}">Disponibilidade</a></li>
                        <li><a href="{{ route('public.review.create') }}">Avaliar</a></li>
                        <li><a href="{{ route('admin.login') }}">Administração</a></li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} Hotel Moz. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
