<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    : array{
        return [
            'id'                  => $this->id,
            'user'                => new UserResource(User::find($this->user_id)),
            'company_name'        => $this->company_name,
            'slug'                => $this->slug,
            'company_logo'        => $this->company_logo,
            'banner'              => $this->banner,
            'company_description' => $this->company_description,
            'website'             => $this->website,
            'address'             => new AddressResource($this->address),
            'company_size'        => $this->company_size,
            'company_type'        => $this->company_type,
            'company_industry'    => $this->company_industry,
            'company_address'     => $this->company_address,
            'tax_code'            => $this->tax_code,
            'followers'           => UserResource::collection($this->whenLoaded('trackings')),
            'created_at'          => $this->created_at,
            'updated_at'          => $this->updated_at
        ];
    }
}
