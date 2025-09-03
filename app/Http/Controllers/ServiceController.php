<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\UserEstateServiceResource;
use App\Models\Service;
use App\Models\UserEstateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            ServiceResource::collection(Service::all())
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        $service = Service::create($request->validated());
        return $this->success(ServiceResource::make($service));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $service->load(["users","estates"]);
        return $this->success(ServiceResource::make($service));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $service->update($request->validated());
        return $this->success(ServiceResource::make($service));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return $this->success(null,204);
    }

    public function myServices(){
        $services = UserEstateService::with(['estate','service'])->where("user_id", Auth::id())->get();
        return $this->success(
            UserEstateServiceResource::collection($services)
        );
    }
}
