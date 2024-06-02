<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Todo');
});
Route::get('/list',[TodoController::class,'list'])->name('list');
Route::get('/todo/{id}',[TodoController::class,'get'])->name('get');
Route::post('/add',[TodoController::class,'add'])->name('add');
Route::post('/update',[TodoController::class,'update'])->name('update');
Route::get('/delete/{id}',[TodoController::class,'delete'])->name('delete');
Route::get('/time', function() {
    return date('Y-m-d H:i:s');
});
