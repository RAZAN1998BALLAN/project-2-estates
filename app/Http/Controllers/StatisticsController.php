<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function getStatistics(){
       return $this->success([
        'users_count' => User::count(),
        'estates_count' => Estate::count(),
        'pending_estates_count' => Estate::where('status','pending')->count(),
        'accepted_estates_count' => Estate::where('status','accepted')->count(),
        'rejected_estates_count' => Estate::where('status','rejected')->count(),
        'views' => (int) Estate::sum('views'),
       ]);
    }
}
