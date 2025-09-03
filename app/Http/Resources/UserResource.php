<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'photo' => $this->photo != null ? url(Storage::url($this->photo)):null,
            'location' => $this->location,
            'location_text' => $this->location_text,
            'is_active' => $this->is_active,
            'phone' => $this->phone,
            'wallets' => WalletResource::collection($this->whenLoaded('wallets'))
        ];
    }
}
