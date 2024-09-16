<?php

use App\Http\Controllers\ProdutosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/products', [ProdutosController::class, "index"]);
Route::post('/products', [ProdutosController::class, "store"]);
Route::put('/products/{productId}', [ProdutosController::class, "update"]);
Route::get('/products/{productId}', [ProdutosController::class, "viewProduct"]);
Route::delete('/products/{productId}', [ProdutosController::class, "delete"]);
