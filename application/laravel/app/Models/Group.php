<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Eloquent
 * @property mixed $omniGroup
 * @property mixed $subGroups
 * @property mixed $products
 */
class Group extends Model
{
    public $timestamps = false;

    /**
     * Атрибуты, для которых разрешено массовое присвоение значений.
     * @var array<int, string>
     */
    protected $fillable = ['id_parent', 'name'];

    /**
     * Получить продукты этой группы
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'id_group');
    }

    /**
     * Получить дочерние группы
     * @return HasMany
     */
    public function subGroups(): HasMany
    {
        return $this->hasMany(Group::class, 'id_parent');
    }
    /**
     * Получить родительскую надгруппу, к которой принадлежит.
     * @return BelongsTo
     */
    public function omniGroup(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_parent');
    }
}
