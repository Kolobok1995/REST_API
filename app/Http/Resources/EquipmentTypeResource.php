<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {  
        try {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'mask' => $this->mask,
            ];
         } catch (\Exception $e) {
            return $this->resource;
        }
    }
}
