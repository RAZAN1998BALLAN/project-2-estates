<?php

namespace App\Http\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class WithRelation
{



    protected $relation;

    public function __construct(string $relation)
    {
        $this->relation = $relation;
    }


     public function handle(Builder $builder, Closure $next)
    {
        $builder->with($this->relation);
    
        return $next($builder);
    }
}
