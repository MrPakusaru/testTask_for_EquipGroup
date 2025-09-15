<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin Eloquent
 */
class Product extends Model
{
    public $timestamps = false;

    /**
     * Отношения, которые всегда должны быть загружены
     * Связка с таблицей 'price'
     * @var array
     */
    protected $with = ['price'];

    /**
     * Получить группу, которой принадлежит продукт.
     * @return BelongsTo
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'id_group');
    }

    /**
     * Получить цену, связанную с продуктом
     * @return HasOne
     */
    public function price(): HasOne
    {
        return $this->hasOne(Price::class, 'id_product');
    }
}
