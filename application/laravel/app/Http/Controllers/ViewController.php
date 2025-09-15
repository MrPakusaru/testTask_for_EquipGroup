<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Класс, обслуживающий запросы, связанные с view
 */
class ViewController extends Controller
{
    /**
     * При обращении возвращает view с каталогом продуктов
     * @return Factory|View
     */
    public function indexCatalog(): Factory|View
    {
        return view('catalog');
    }

    /**
     * При обращении с id возвращает view с карточкой продукта
     * @param $id
     * @return Factory|View
     */
    public function indexProduct($id): Factory|View
    {
        return view('product', ['id' => $id]);
    }
}
