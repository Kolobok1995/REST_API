<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends BaseController
{
    public function index(Request $request)
    {
        $query = \DB::table('equipment as e')
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

            if ($request->has('type_name')) {
                $query = $query->where('et.name', 'like', '%' . $request->type_name . '%');
            }

            $test = [];
            $test['data']['success'] = $query->get();
            $test['data']['errors'] = 123;
            return EquipmentResource::collection($test);
            /*
        return EquipmentResource::collection($test->success)->additional(['errors' => [
            'key' => 'value',
        ]]);
        */
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
