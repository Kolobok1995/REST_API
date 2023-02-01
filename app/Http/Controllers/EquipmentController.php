<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Services\EquipmentService;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Requests\EquipmentRequest;

class EquipmentController extends BaseController
{
    public function __construct(EquipmentService $equipmentService) {
        $this->service = $equipmentService;
    }

    /**
     * Отображаем список всего оборудования
     *
     * @param Request $request
     * @return JsonResource
     */
    public function index(Request $request): JsonResource
    {
        $this->service->init();
        $this->service->filterSearchField($request->all());
        $this->service->executeGet();

        return EquipmentResource::collection(
            $this->service->getData()
        );
    }
    
    /**
     * Отображает оборудование по id
     *
     * @param integer $equipment
     * @return JsonResource
     */
    public function show(int $equipment): JsonResource
    {
        $this->service->init();
        $this->service->executeFirstOrFail($equipment);

        return new EquipmentResource(
           $this->service->getDataObject()
        );
    }

    /**
     * Добавляет новое оборудование
     *
     * @param Request $request
     * @return JsonResource
     */
    public function store(EquipmentRequest $request)
    {
        return response()->json([
            'errors' => [
                $request->getErrors()
            ], 
            'success' => [
                $request->getSuccess()
            ], 
        ]);
    }
    /*
    public function update() 
    {
        $listEquipment = Equipment::with('equipment_type');
        return EquipmentResource::collection(Equipment::all());
    }
    
    public function destroy() 
    {
        $listEquipment = Equipment::with('equipment_type');
        return EquipmentResource::collection(Equipment::all());
    }
    
    public function edit() 
    {
        $listEquipment = Equipment::with('equipment_type');
        return EquipmentResource::collection(Equipment::all());
    }
    */
}
