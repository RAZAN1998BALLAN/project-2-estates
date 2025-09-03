<?php

namespace App\Http\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class LikeFilter{


    protected $key;
    protected $column;

    public function __construct(string $key, string $column = null){
        $this->key = $key;
        $this->column = $column ?? $key;
    }


    public function handle(Builder $builder, Closure $next)
    {
        $value = request()->get($this->key);
        if(isset($value)) {
            $builder->whereLike($this->column, '%'.$value.'%');
        }
        return $next($builder);
    }
}
