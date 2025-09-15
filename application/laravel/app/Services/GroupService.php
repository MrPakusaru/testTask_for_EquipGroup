<?php

namespace App\Services;

use App\Models\Group;
use Illuminate\Support\Collection;

/**
 * Класс, содержащий дополнительные функции для работы с Group
 */
class GroupService
{
    /**
     * Возвращает `true` в случае наличия подгрупп у группы, иначе `false`
     * @param Group $group
     * @return bool
     */
    public static function ifHaveSubGroups(Group $group): bool
    {
        return $group->subGroups->isNotEmpty();
    }

    /**
     * Рекурсивно получает все дочерние записи групп из коллекции
     */
    public static function getAllSubGroups($parentId): Collection
    {
        $subGroupsCollection = new Collection();
        //Ищет дочерние группы по 'id_parent'
        $subGroups = Group::find($parentId)->subGroups;
        //Добавление в коллекцию дочерних групп (без групп-нодов) и рекурсивный вызов
        foreach ($subGroups as $group) {
            if (!GroupService::ifHaveSubGroups($group)) {
                $subGroupsCollection->push($group);
            }
            $subGroupsCollection = $subGroupsCollection->merge(self::getAllSubGroups($group->id));
        }
        return $subGroupsCollection;
    }

    /**
     * Рекурсивно получает все родительские записи групп из коллекции
     */
    public static function getAllOmniGroups($groupId): Collection
    {
        $omniGroupsCollection = new Collection();
        $group = Group::find($groupId);
        //Добавление в коллекцию родительских групп и рекурсивный вызов
        $omniGroupsCollection->push($group);
        if (!is_null($group->omniGroup)) {
            $omniGroupsCollection = $omniGroupsCollection->merge(self::getAllOmniGroups($group['id_parent']));
        }
        return $omniGroupsCollection;
    }

    /**
     * Обрабатывает полученную коллекцию и достаёт из неё id всех дочерних групп
     */
    public static function getIdSubGroups(int $parentId): array
    {
        return self::getAllSubGroups($parentId)->pluck('id')->toArray();
    }

    /**
     * Возвращает количество прордуктов в группе с id
     * @param $idGroup
     * @return int
     */
    public static function getProductQuantityInGroup($idGroup): int
    {
        return Group::find($idGroup)->products->count();
    }

    /**
     * Получает id группы и возвращает иерархическую коллекцию всех дожерних групп
     * @param $idGroup
     * @return Collection
     */
    public static function getHierarchyGroups($idGroup): Collection
    {
        $rootGroups = Group::where('id_parent', $idGroup)->get();
        if ($rootGroups->count() === 1) {
            return $rootGroups->first();
        }
        return self::makeHierarchyGroups($rootGroups);
    }

    /**
     * Получает группу и возвращает иерархическую коллекцию из дочерних груп
     * @param Collection $groups
     * @return Collection
     */
    public static function makeHierarchyGroups(Collection $groups): Collection
    {
        $multiLevelList = new Collection();
        foreach ($groups as $group) {
            $groupArray = new Collection($group);
            //Если нет дочерних групп, то добавить кол-во продуктов группы в свойство `productsQuantity`
            //Иначе добавить сумму значений `productsQuantity` в дочерних группах
            if (!GroupService::ifHaveSubGroups($group)) {
                $groupArray->put('productsQuantity', GroupService::getProductQuantityInGroup($group->id));
            } else {
                $tempSubGroup = self::makeHierarchyGroups($group->subGroups);
                $groupArray->put('productsQuantity', $tempSubGroup->sum('productsQuantity'));
                //Если есть дочерние группы, то добавить их с ключём `subGroup`
                $groupArray->put('subGroup', $tempSubGroup);
            }
            $multiLevelList->push($groupArray);
        }
        return $multiLevelList;
    }
}
