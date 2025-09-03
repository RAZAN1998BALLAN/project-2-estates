<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EstateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => $this->title,
            'image' => url(Storage::url($this->image)),
            'description' => $this->description,
            'price' => (int) $this->price,
            'address' => $this->address,
            'location' => $this->castLocation(),
            'area' => (double) $this->area,
            'listing_type' => $this->listing_type,
            'estate_type' => $this->estate_type,
            'status' => $this->status,
            'other_data' => $this->other_data,
            'rate_avg' => $this->calcRate(),
            'closed_at' => $this->closed_at,
            'views' => $this->views,
            'user' => UserResource::make($this->whenLoaded('user')),
            ...$this->rates()
        ];
    }

    private function calcRate(){
        if(!$this->rate_count)
            return 0;
        return $this->rate / $this->rate_count;
    }

    private function castLocation(){
        return [
            'lat' => (double) $this->location['lat'],
            'lon' => (double) $this->location['lon'],
        ];
    }
    private function rates(){
        if(Auth::user()->is_admin){
            return [
                'rates' => RateResource::collection($this->whenLoaded('rates'))
            ];
        }
        return [];
    }
}
