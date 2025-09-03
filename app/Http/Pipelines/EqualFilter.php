<?php

namespace App\Http\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class EqualFilter{


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
            $builder->where($this->column,$value);
        }
        return $next($builder);
    }
}
