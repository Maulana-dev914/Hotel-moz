<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AvailabilityController;
use App\Http\Controllers\Public\ReviewController as PublicReviewController;
use App\Http\Controllers\Public\RoomController as PublicRoomController;
use App\Http\Controllers\Public\ReservationController as PublicReservationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\StayController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('public.home');
Route::get('/rooms', [PublicRoomController::class, 'index'])->name('public.rooms.index');
Route::get('/availability', [AvailabilityController::class, 'index'])->name('public.availability.index');
Route::post('/availability/search', [AvailabilityController::class, 'search'])->name('public.availability.search');
Route::get('/reservation', [PublicReservationController::class, 'create'])->name('public.reservation.create');
Route::post('/reservation', [PublicReservationController::class, 'store'])->name('public.reservation.store');
Route::get('/reservation/success', [PublicReservationController::class, 'success'])->name('public.reservation.success');
Route::get('/review', [PublicReviewController::class, 'create'])->name('public.review.create');
Route::post('/review', [PublicReviewController::class, 'store'])->name('public.review.store');

/*
|--------------------------------------------------------------------------
| Rotas de Autenticação
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [LogoutController::class, 'logout'])->name('admin.logout');

// Recuperação de Senha
Route::get('/admin/password/forgot', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('admin.password.forgot');
Route::post('/admin/password/email', [ForgotPasswordController::class, 'sendResetLink'])->name('admin.password.email');
Route::get('/admin/password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('admin.password.update');

/*
|--------------------------------------------------------------------------
| Rotas Administrativas (Protegidas)
|--------------------------------------------------------------------------
*/

// Proteger todas as rotas /admin/* exceto login, logout e recuperação de senha
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Quartos
    Route::resource('rooms', RoomController::class);
    
    // Hóspedes
    Route::resource('guests', GuestController::class);
    
    // Reservas
    Route::resource('reservations', ReservationController::class);
    
    // Estadias
    Route::resource('stays', StayController::class)->except(['update', 'edit']);
    Route::post('/stays/{stay}/checkout', [StayController::class, 'checkout'])->name('stays.checkout');
    
    // Avaliações
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{review}/disapprove', [ReviewController::class, 'disapprove'])->name('reviews.disapprove');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    // Usuários
    Route::resource('users', UserController::class);
    
    // Perfil e Definições
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileController::class, 'updateSettings'])->name('settings.update');
});

// Rota catch-all para qualquer tentativa de acessar /admin sem autenticação
Route::fallback(function () {
    if (request()->is('admin/*') && !request()->is('admin/login') && !request()->is('admin/logout') && 
        !request()->is('admin/password/*')) {
        if (!session()->has('user_id')) {
            return redirect()->route('admin.login')->with('error', 'Acesso negado. Você precisa fazer login.');
        }
    }
    abort(404);
});
