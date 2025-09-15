<?php

namespace App\Http\Controllers;

use App\Services\GroupService;
use Illuminate\Http\JsonResponse;

/**
 * Класс, обслуживающий запросы с сущностями Group
 */
class GroupController extends Controller
{
    /**
     * Получает иерархическую структуру из групп и передаёт клиенту в JSON
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = GroupService::getHierarchyGroups(0);
        return self::prepareResponse($data);
    }

    /**
     * Получает список родительских групп к группе с id, передаёт клиенту в JSON
     * @param $id
     * @return JsonResponse
     */
    public static function getOmniGroups($id): JsonResponse
    {
        $data = GroupService::getAllOmniGroups($id);
        return parent::prepareResponse($data);
    }
}
