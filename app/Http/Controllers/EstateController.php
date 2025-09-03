<?php

namespace App\Http\Controllers;

use App\Http\Pipelines\Estates\EstatesPipeline;
use App\Http\Requests\ChangeEstateStateRequest;
use App\Http\Requests\CreateEstateRequest;
use App\Http\Requests\DeleteEstateRequest;
use App\Http\Requests\RateEstateRequest;
use App\Http\Requests\UpdateEstateRequest;
use App\Http\Resources\EstateResource;
use App\Models\Estate;
use App\Models\EstateUserFavorite;
use App\Models\User;
use App\Notifications\FcmNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Estate::query();

        return $this->success(
            EstateResource::collection(EstatesPipeline::make($query)->get())
        );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEstateRequest $request)
    {
        $fields = $request->validated();
        $fields['image'] = $this->saveFile($request->file('image'));

        $estate = Estate::create(array_merge([
            'user_id' => Auth::id(),
        ], $fields));
        return $this->success(EstateResource::make($estate));
    }

    /**
     * Display the specified resource.
     */
    public function show(Estate $estate)
    {
        if (!Auth::user()->is_admin) {
            $estate->views = $estate->views + 1;
            $estate->save();
            
        return $this->success(EstateResource::make($estate->load(['user',])));
        }
        
        return $this->success(EstateResource::make($estate->load(['user','rates'])));
    }

    public function favorite(Estate $estate){

        $user  = Auth::user();
        $relation = EstateUserFavorite::where('estate_id',$estate->id)->where('user_id',$user->id)->first();
        if($relation){
            $relation->delete();
        }
        else{
            $user->favorites()->attach($estate);
        }
        return $this->success();

    }

    public function myFavorite(){
        $user = Auth::user();
        return $this->success(EstateResource::collection($user->favorites));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstateRequest $request, Estate $estate)
    {
        $fields = $request->validated();
        if ($request->hasFile('image')) {
            $this->deleteFile($estate->image);
            $fields['image'] = $this->saveFile($request->file('image'));
        }

        $estate->update($fields);

        return $this->success(EstateResource::make($estate));
    }


    public function changeState(ChangeEstateStateRequest $request, Estate $estate)
    {
        $estate->update(
            $request->validated()
        );
        $notificationService = new FcmNotificationService(Auth::user(), $estate->title,'changed to '.$request->status);
        $notificationService->send();
        return $this->success(EstateResource::make($estate));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteEstateRequest $request, Estate $estate)
    {
        $estate->delete();
        return $this->success();
    }


    public function rate(RateEstateRequest $request, Estate $estate)
    {
        $rate = $estate->raters()->where('user_id', Auth::id())->withPivot('rate')->first();
        if (!$rate) {
            $estate->raters()->attach(Auth::id(), ['rate' => $request->rate]);
            $estate->rate = $estate->rate + $request->rate;
            $estate->rate_count = $estate->rate_count + 1;
        } else {

            $estate->rate = $estate->rate + $request->rate - $rate->pivot->rate;
            $estate->raters()->updateExistingPivot(Auth::id(), [
                'rate' => $request->rate,
                'updated_at' => now()
            ]);
        }
        $estate->save();
        return $this->show($estate);
    }
}
