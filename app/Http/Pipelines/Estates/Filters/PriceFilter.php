<?php

namespace App\Http\Pipelines\Estates\Filters;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class PriceFilter{

    public function handle(Builder $builder, Closure $next)
    {
        if(request()->has('min_price')){
            $builder->where('price' ,">=" , request()->get('min_price'));
        }
        if(request()->has('max_price')){
            $builder->where('price' ,"<=" , request()->get('max_price'));
        }
        return $next($builder);
    }
}
