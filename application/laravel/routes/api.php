<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

//Получение иерархического списка групп
Route::get('/groups/', [GroupController::class, 'index']);
//Получение списка всех родительских групп
Route::get('/groups/omnigroups/{id}', [GroupController::class, 'getOmniGroups']);
//Получение списка продуктов
Route::get('/products/', [ProductController::class, 'index']);
//Получение информации о продукте по его id
Route::get('/products/{id}', [ProductController::class, 'indexProduct']);
