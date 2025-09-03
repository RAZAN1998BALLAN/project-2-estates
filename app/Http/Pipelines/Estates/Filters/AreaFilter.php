<?php

namespace App\Http\Pipelines\Estates\Filters;
use Closure;
use Illuminate\Database\Eloquent\Builder;

class AreaFilter{

    public function handle(Builder $builder, Closure $next)
    {
        if(request()->has('min_area')){
            $builder->where('area' ,">=" , request()->get('min_area'));
        }
        if(request()->has('max_area')){
            $builder->where('area' ,"<=" , request()->get('max_area'));
        }
        return $next($builder);
    }
}
