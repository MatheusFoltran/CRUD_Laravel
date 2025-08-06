<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdutoController;

Route::get('/', function () {
    return redirect()->route('produtos.index');
});

Route::resource('produtos', ProdutoController::class);