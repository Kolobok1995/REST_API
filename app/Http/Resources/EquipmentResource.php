<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
//use App\Http\Resources\EquipmentTypeResource;

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

        /*
        $result = [];

        $result['errors'] = [123];

        foreach ($this['success'] as $item) {
            $result['success'][] = [
                'id' => $item->equipment_id,
                'serial_number' => $item->serial_number,
                'desc' => $item->desc,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'equipment_type' => [
                    'id' => $item->type_id,
                    'name' => $item->type_name,
                    'mask' => $item->type_mask,
                ]
            ];
        }
        */
      //  dd($this->resource);
      //  dd($result);
        return $this->resource;
    }

}