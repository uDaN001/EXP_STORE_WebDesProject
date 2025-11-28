<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('customers.login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('customers.authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('customers.logout');

// Games
Route::get('/games', [GameController::class, 'index'])->name('games.index');
Route::get('/games/search', [GameController::class, 'search'])->name('games.search');
Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
Route::post('/games', [GameController::class, 'store'])->name('games.store');
Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
Route::get('/games/{game}/edit', [GameController::class, 'edit'])->name('games.edit');
Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

// Shopping Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/add/{game}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/remove/{game}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Customers
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

// Orders
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

// Admin Routes
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');

Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    // Game Management
    Route::get('/games', [AdminController::class, 'games'])->name('admin.games');
    Route::get('/games/create', [AdminController::class, 'createGame'])->name('admin.games.create');
    Route::post('/games', [AdminController::class, 'storeGame'])->name('admin.games.store');
    Route::get('/games/{game}/edit', [AdminController::class, 'editGame'])->name('admin.games.edit');
    Route::put('/games/{game}', [AdminController::class, 'updateGame'])->name('admin.games.update');
    Route::delete('/games/{game}', [AdminController::class, 'deleteGame'])->name('admin.games.delete');
});
