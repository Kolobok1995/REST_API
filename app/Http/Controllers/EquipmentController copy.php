<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Request;
use DB;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentController extends BaseController
{
    public function index(Request $request): JsonResource
    {
        /*
        $query = DB::table('equipment as e')
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

            $test = new \stdClass();
            $test->success = $query->get();
            $test->errors = 123;
            */
          //  dd(new EquipmentResource($test));

        return new EquipmentResource::collection(Equipment::get());
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
