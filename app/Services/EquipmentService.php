<?php

namespace App\Services;

use App\Services\Base\BaseServiceApi;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Query\Builder;
use App\Http\Resources\EquipmentResource;

class EquipmentService extends BaseServiceApi
{
    private Builder $query;
    private string $tableName;

    private function getSearchFields()
    {
        return [
            'equipment_id' => [
                'column' => 'e.id',
                'operator' => '=',
            ],
            'serial_number' => [
                'column' => 'e.serial_number',
                'operator' => 'like',
            ],
            'desc' => [
                'column' => 'e.desc',
                'operator' => 'like',
            ],
            'type_name' => [
                'column' => 'et.name',
                'operator' => 'like',
            ],
            'mask' => [
                'column' => 'et.mask',
                'operator' => 'like',
            ],
        ];
    }

    public function init(): void
    {
        $this->query = \DB::table('equipment as e')
            ->select([
                'e.id as equipment_id',
                'e.serial_number as serial_number',
                'e.desc as desc',
                'e.created_at as created_at',
                'e.updated_at as updated_at',
                'et.id as type_id',
                'et.name as type_name',
                'et.mask as type_mask',
            ])
            ->leftJoin('equipment_types as et', 'et.id', 'e.type_id');
    }
    
    public function searchByAttributes(array $params = []): void
    {
        foreach ($this->getSearchFields() as $key => $field) {
            if (! array_key_exists($key, $params)) {
               continue;
            }

            $this->query = $this->query->where($field['column'], $field['operator'], $params[$key]);
        }
    }

    public function executeGet()
    {
        $this->data = $this->query
            ->get()
            ->toArray();
    }
}