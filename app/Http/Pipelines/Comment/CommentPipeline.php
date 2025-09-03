<?php

namespace App\Http\Pipelines\Comment;

use App\Http\Pipelines\EqualFilter;
use App\Http\Pipelines\Estates\Filters\AreaFilter;
use App\Http\Pipelines\Estates\Filters\PriceFilter;
use App\Http\Pipelines\Estates\Filters\StatusFilter;
use App\Http\Pipelines\LikeFilter;
use App\Http\Pipelines\OrderFilter;
use App\Http\Pipelines\WithRelation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\Pipeline;
use PhpParser\Node\Expr\BinaryOp\Equal;

class CommentPipeline extends Pipeline {

    protected function pipes():array
    {
        return [
            new EqualFilter('estate_id'),
            new WithRelation('user'),
        ];
    }

    public static function make(Builder $builder): Builder
    {
        return app(static::class)
            ->send($builder)
            ->thenReturn();
    }

}