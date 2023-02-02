<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\EquipmentType;
use App\Http\Resources\EquipmentTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentTypeController extends BaseController
{
    /**
     * Отображаем список всего оборудования
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $equipmentType = EquipmentType::simplePaginate(10)->toArray();
        
        return EquipmentTypeResource::collection(
            $equipmentType['data']
        );
    }
}
