<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\WorkExperienceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DebugController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/templates', function () {
    return view('templates');
})->name('templates');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Contact form submission for the main contact page
Route::post('/contact', [ContactController::class, 'sendContactForm'])->name('contact.send');

// Contact form submission for portfolios
Route::post('/portfolios/{portfolio}/contact', [ContactController::class, 'send'])->name('portfolios.contact');

// Authentication routes
Auth::routes();

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Portfolio routes
    Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::get('/portfolios/setup', [PortfolioController::class, 'setup'])->name('portfolios.setup');
    Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
    Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show'])->name('portfolios.show');
    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
    
    // New route for inline portfolio element updates
    Route::patch('/portfolios/{portfolio}/update-element', [PortfolioController::class, 'updateElement'])
        ->name('portfolios.update-element');

    // Dedicated route for banner uploads
    Route::post('/portfolios/{portfolio}/upload-banner', [PortfolioController::class, 'uploadBanner'])
        ->name('portfolios.upload-banner');

    // Work Experience Routes
    Route::get('/experiences/{experience}', [WorkExperienceController::class, 'show'])
        ->name('experiences.show');
    Route::post('/experiences', [WorkExperienceController::class, 'store'])
        ->name('experiences.store');
    Route::put('/experiences/{experience}', [WorkExperienceController::class, 'update'])
        ->name('experiences.update');
    Route::delete('/experiences/{experience}', [WorkExperienceController::class, 'destroy'])
        ->name('experiences.destroy');

    // Gallery Routes
    Route::post('/portfolio/gallery/upload', [GalleryController::class, 'upload'])
        ->name('portfolio.gallery.upload');
    Route::delete('/portfolio/gallery/{image}', [GalleryController::class, 'destroy'])
        ->name('portfolio.gallery.destroy');
    // New routes for gallery caption and reordering
    Route::get('/portfolio/gallery/{image}/caption', [GalleryController::class, 'getCaption'])
        ->name('portfolio.gallery.get-caption');
    Route::post('/portfolio/gallery/{image}/caption', [GalleryController::class, 'saveCaption'])
        ->name('portfolio.gallery.save-caption');
    Route::post('/portfolio/gallery/reorder', [GalleryController::class, 'reorder'])
        ->name('portfolio.gallery.reorder');

    // Debug routes
    Route::get('/debug/form', [DebugController::class, 'diagnosticForm'])->name('debug.form');
    Route::post('/debug/submit', [DebugController::class, 'debug'])->name('debug.submit');
});

require __DIR__.'/auth.php';
