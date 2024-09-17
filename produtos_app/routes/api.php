<?php

use App\Http\Controllers\ProdutosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProdutosController::class, "index"]);
Route::post('/products', [ProdutosController::class, "store"]);
Route::put('/products/{productId}', [ProdutosController::class, "update"])->where('productId', '[0-9]+');
Route::get('/products/{productId}', [ProdutosController::class, "viewProduct"])->where('productId', '[0-9]+');
Route::delete('/products/{productId}', [ProdutosController::class, "delete"])->where('productId', '[0-9]+');
