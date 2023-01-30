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

class EquipmentController extends BaseController
{
    public function __construct(EquipmentService $equipmentService) {
        $this->service = $equipmentService;
    }

    public function index(Request $request)
    {
        $this->service->init();
        $this->service->searchByAttributes($request->all());
        $this->service->executeGet();

        return EquipmentResource::collection(
            $this->service->getData()
        );
    }
    
    public function show(int $equipment) 
    {
        $listEquipment = Equipment::with('equipment_type');
        return new EquipmentResource(Equipment::findOrFail($equipment));
    }

    public function store(Request $request) 
    {
        dd();
    }
    /*
    public function show() 
    {
        $listEquipment = Equipment::with('equipment_type');
        return EquipmentResource::collection(Equipment::all());
    }
    
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
