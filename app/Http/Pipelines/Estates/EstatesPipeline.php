<?php

namespace App\Http\Pipelines\Estates;

use App\Http\Pipelines\EqualFilter;
use App\Http\Pipelines\Estates\Filters\AreaFilter;
use App\Http\Pipelines\Estates\Filters\PriceFilter;
use App\Http\Pipelines\Estates\Filters\StatusFilter;
use App\Http\Pipelines\LikeFilter;
use App\Http\Pipelines\OrderFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Pipeline;
use PhpParser\Node\Expr\BinaryOp\Equal;

class EstatesPipeline extends Pipeline {

    protected function pipes():array
    {
        return [
            new OrderFilter('views'),
            new PriceFilter(),
            new AreaFilter(),
            new StatusFilter(),
            new LikeFilter('title'),
            new LikeFilter('address'),
            new EqualFilter('estate_type'),
            new EqualFilter('listing_type')
        ];
    }

    public static function make(Builder $builder): Builder
    {
        return app(static::class)
            ->send($builder)
            ->thenReturn();
    }

}