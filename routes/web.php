<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\BookshelfController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/books/print', [BookController::class, 'print'])->name('books.print');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::match(['put', 'patch'], 'books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');

    Route::get('/bookshelves', [BookshelfController::class, 'index'])->name('bookshelves');
    Route::get('/bookshelves/create', [BookshelfController::class, 'create'])->name('bookshelves.create');
    Route::post('/bookshelves/store', [BookshelfController::class, 'store'])->name('bookshelves.store');
    Route::get('/bookshelves/{id}/edit', [BookshelfController::class, 'edit'])->name('bookshelves.edit');
    Route::match(['put', 'patch'], 'bookshelves/{id}', [BookshelfController::class, 'update'])->name('bookshelves.update');
    Route::delete('/bookshelves/{id}', [BookshelfController::class, 'destroy'])->name('bookshelves.destroy');

    Route::get('/loans', [LoanController::class, 'index'])->name('loans');
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
    Route::get('/loans/print', [LoanController::class, 'print'])->name('loans.print');
    Route::post('/loans/store', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/loans/{id}/edit', [LoanController::class, 'edit'])->name('loans.edit');
    Route::match(['put', 'patch'], 'loans/{id}', [LoanController::class, 'update'])->name('loans.update');
    Route::delete('/loans/{id}', [LoanController::class, 'destroy'])->name('loans.destroy');

    Route::get('/returns', [ReturnController::class, 'index'])->name('returns');
    Route::get('/returns/create', [ReturnController::class, 'create'])->name('returns.create');
    Route::get('/returns/print', [ReturnController::class, 'print'])->name('returns.print');
    Route::post('/returns/store', [ReturnController::class, 'store'])->name('returns.store');
    Route::delete('/returns/{id}', [ReturnController::class, 'destroy'])->name('returns.destroy');
    Route::get('/returns/{id}/edit', [ReturnController::class, 'edit'])->name('returns.edit');
    Route::patch('/returns/{id}', [ReturnController::class, 'update'])->name('returns.update');
});

require __DIR__ . '/auth.php';
