<?php

use App\Http\Controllers\DrawController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushSubscriptionController;
use App\Livewire\Practise;
use App\Livewire\Statistics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['reset' => false, 'confirm' => false, 'verify' => false]);

Route::post('user/forgot-password', [PasswordController::class, 'forgot'])->name('user-password-forgot');
Route::get('user/recover/{code}', [PasswordController::class, 'recover'])->name('user-recover');

Route::middleware('auth')->group(function () {
    Route::livewire('/', Practise::class)->name('home');
    Route::redirect('/home', '/');

    Route::livewire('statistik', Statistics::class)->name('statistics');

    Route::post('push/subscribe', [PushSubscriptionController::class, 'store'])->name('push.subscribe');
    Route::delete('push/subscribe', [PushSubscriptionController::class, 'destroy'])->name('push.unsubscribe');

    Route::get('draw/{practise}', [DrawController::class, 'show'])->name('shuffle');
    Route::get('shuffle/{practise}', fn (App\Models\Practise $practise) => redirect()->route('shuffle', $practise));

    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('profile', [ProfileController::class, 'update'])->name('change-password');
    Route::redirect('change-avatar', 'profile');
    Route::redirect('change-password', 'profile');
});
