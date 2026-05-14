<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SkillRequestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MilestoneController;
use Illuminate\Validation\Rules\Can;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/marketplace', [SkillController::class, 'index'])->name('marketplace');
    Route::get('/my-skills', [SkillController::class, 'mySkills'])->name('skills.my');
    Route::get('/skills/create', [SkillController::class, 'create'])->name('skills.create');
    Route::post('/skills', [SkillController::class, 'store'])->name('skills.store');
  
Route::get('/skills/{skill}/edit', [SkillController::class, 'edit'])->name('skills.edit');
Route::post('/skills/{skill}/request',[SkillRequestController::class,'store'])->name('skill.request');
Route::get('/skills/{id}/delete',[SkillController::class,'destroy'])->name('skills.delete');

Route::patch('/skills/{skill}', [SkillController::class, 'update'])->name('skills.update');

Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
Route::patch('/milestones/{milestone}/toggle', [MilestoneController::class, 'toggle'])->name('milestones.toggle');
});

//COntroller Gate Code
Route::get('/gate', [SkillController::class, 'gate'])
    ->name('gate') ->can('isadmin');


require __DIR__.'/auth.php';
