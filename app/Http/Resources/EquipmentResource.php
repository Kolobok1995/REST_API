<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'id' => $this->equipment_id,
            'serial_number' => $this->serial_number,
            'desc' => $this->desc,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'equipment_type' => [
                'id' => $this->type_id,
                'name' => $this->type_name,
                'mask' => $this->type_mask,
            ]
        ];
        
        return $this->resource;
    }

}