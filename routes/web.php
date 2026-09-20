<?php

use App\Http\Controllers\GroupApprovedController;
use App\Http\Controllers\IndividualRegistrationController;
use App\Livewire\Public\CamperRegistrationForm;
use App\Livewire\Public\GroupEventRegistrationForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\RegistrationSuccess;



// Portal Web Público / Form Ingestion Routes
Route::prefix('public')->group(function () {
    Route::get('/group-request', GroupEventRegistrationForm::class)->name('public.group.register');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});


// 1. Ruta pública (Registro nuevo)
Route::get('/camper-register', CamperRegistrationForm::class)
    ->name('public.camper.register');

// 2. Ruta con middleware 'signed' (Edición mediante enlace seguro)
Route::get('/camper-register/edit/{token}', CamperRegistrationForm::class)
    ->middleware('signed')
    ->name('public.camper.edit');


Route::get('/registration/success', RegistrationSuccess::class)->name('registration.success');


// Rutas de la demo sin token
Route::get('/group-approved', [GroupApprovedController::class, 'show'])->name('groups.approved');
Route::get('/register-individual', [IndividualRegistrationController::class, 'create'])->name('groups.register-individual');
Route::post('/register-individual', [IndividualRegistrationController::class, 'store'])->name('groups.store-individual');

require __DIR__.'/settings.php';