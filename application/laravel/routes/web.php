<?php

use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

//Редирект в каталог продуктов
Route::get('/', function () {
    return redirect('/catalog');
});
//Каталог продуктов с blade страницей
Route::get('/catalog', [ViewController::class, 'indexCatalog']);
//Страница продукта по id
Route::get('/products/{id}', [ViewController::class, 'indexProduct']);
