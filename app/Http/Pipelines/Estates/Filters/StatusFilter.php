<?php

namespace App\Http\Pipelines\Estates\Filters;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StatusFilter{

    public function handle(Builder $builder, Closure $next)
    {
        if(Auth::user()->is_admin){
            if(request()->has("status")){
                $status = request()->get("status");
                $builder->where("status",$status);
            }
        }else{
            $builder->where("status","accepted");
            $builder->orWhere('user_id',Auth::id());
        }
        return $next($builder);
    }
}
