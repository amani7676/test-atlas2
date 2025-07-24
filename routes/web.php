<?php

use App\Livewire\Pages\Home\Home;
use App\Livewire\Pages\Tablelists\Tablelists;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get("/", Home::class)->name('home');
Route::get("lists", Tablelists::class)->name('table_list');
