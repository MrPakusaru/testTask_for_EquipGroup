<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Product;
use App\Services\GroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

/**
 * Класс, обслуживающий запросы с сущностями Product
 */
class ProductController extends Controller
{
    /**
     * Получает в запросе ряд параметров, обрабатывает и возвращает обработанный список продуктов
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        //Обработка параметров запроса
        $params = self::prepareParams($request);
        //Обработка списка продуктов согласно параметрам
        $productsByGroup = self::getProductsByGroup($params->get('id_group'));
        $productsAfterSort = self::sortProducts($productsByGroup, $params->get('sort_by'))->values();
        $productsChunked = self::chunkProducts(
            $productsAfterSort,
            $params->get('page_num'),
            $params->get('chunk_by')
        )->values();

        return self::prepareResponse(
            $productsChunked,
            ['max_pages' => ceil($productsByGroup->count() / $params->get('chunk_by'))]
        );
    }

    /**
     * Возвращает информацию о продукте с id
     * @param $id
     * @return JsonResponse
     */
    public static function indexProduct($id): JsonResponse
    {
        $product = Product::find($id);
        return self::prepareResponse($product);
    }

    /**
     * Проверяет и подготавливает параметры запроса
     * @param Request $request
     * @return Collection
     */
    private static function prepareParams(Request $request): Collection
    {
        $params = new Collection();
        //Проверка на заполненность полей, их валидация на тип, и установка значений по умолчанию
        $params->put('id_group', $request->filled('id_group') ? $request->integer('id_group', 0) : 0);
        $params->put('sort_by', $request->filled('sort_by') ? $request->string('sort_by', 'name') : 'name');
        $params->put('page_num', $request->filled('page_num') ? $request->integer('page_num', 1) : 1);
        $params->put('chunk_by', $request->filled('chunk_by') ? $request->integer('chunk_by', 6) : 6);
        return $params;
    }

    /**
     * Возвращает набор продуктов в зависимости от id группы
     * @param $idGroup
     * @return Collection
     */
    private static function getProductsByGroup($idGroup): Collection
    {
        //Если поле `id_group` = 0, то вернуть весь список
        if ($idGroup === 0) {
            return Product::all();
        }
        //Получить группу по id
        $group = Group::find($idGroup);
        //Проверить группу на наличие подгрупп
        $ifSubGroups = GroupService::ifHaveSubGroups($group);
        //Если подгруппы имеются, то вернуть набор `Product` всех подгрупп
        if ($ifSubGroups) {
            $groups_id = GroupService::getIdSubGroups($idGroup);
            return Product::whereIn('id_group', $groups_id)->get();
        }
        //Иначе вернуть набор `Product` текущей группы
        return $group->products;
    }

    /**
     * Возвращает набор продуктов в отсортированном виде
     * @param Collection $products
     * @param $typeSort
     * @return Collection
     */
    private static function sortProducts(Collection $products, $typeSort): Collection
    {
        switch ($typeSort) {
            case 'price':
                return $products->sortBy('price.price');
            case 'price_desc':
                return $products->sortByDesc('price.price');
            case 'name_desc':
                return $products->sortByDesc('name');
            default:
                return $products->sortBy('name');
        }
    }

    /**
     * Разбивает коллекцию продуктов на скопления
     * @param Collection $products
     * @param int $page
     * @param int $size
     * @return Collection
     */
    private static function chunkProducts(Collection $products, int $page, int $size): Collection
    {
        return $products->forPage($page, $size);
    }
}
