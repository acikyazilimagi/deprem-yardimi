<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'city' => $this->city,
            'district' => $this->district,
            'street' => $this->street,
            'street2' => $this->street2,
            'apartment' => $this->apartment,
            'apartment_no' => $this->apartment_no,
            'apartment_floor' => $this->apartment_floor,
            'phone' => $this->phone,
            'address' => $this->address,
            'fullname' => $this->fullname,
            'source' => $this->source,
        ];
    }
}
