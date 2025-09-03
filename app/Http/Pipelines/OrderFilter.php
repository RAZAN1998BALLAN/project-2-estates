<?php

namespace App\Http\Pipelines;

use Closure;
use Illuminate\Database\Eloquent\Builder;

class OrderFilter
{



    protected $column;

    public function __construct(string $column = 'created_at')
    {
        $this->column = $column;
    }


     public function handle(Builder $builder, Closure $next)
    {
        
        $orderType = strtolower(request()->get('order_type', 'desc'));

        if (in_array($orderType, ['asc', 'desc'])) {
            if($orderType == 'desc') {
                $builder->orderByDesc($this->column );
            }else {
                $builder->orderBy($this->column );
            }
        }

        return $next($builder);
    }
}
