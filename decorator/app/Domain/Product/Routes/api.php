<?php


use App\Domain\Product\Http\Controllers\Api\Backend\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'index']);
