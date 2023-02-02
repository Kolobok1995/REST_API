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

        return EquipmentResource::collection(
            $this->service->getResult()
        );
    }

    /**
     * Добавляет новое оборудование
     *
     * @param Request $request
     * @return JsonResource
     */
    public function store(EquipmentRequest $request): JsonResource
    {
        $this->service->init();
        $this->service->setErrors($request->getErrors());
        $this->service->setSuccess($request->getSuccess());
        $this->service->create();

        return EquipmentResource::collection(
            $this->service->getResult()
        );
    }
    
    /**
     * Сохраняет оборудование
     *
     * @param Request $request
     * @param integer $equipment
     * @return void
     */
    public function update(Request $request, int $equipment): JsonResource
    {
        $model = Equipment::where('id', $equipment)
            ->first();

        if (! $model instanceof Equipment) {
            return EquipmentResource::collection(
                [
                    'error' => 'id ' . $equipment . ' не найден',
                    'data' => []
                ]
            );
        }

        $model->fill($request->all());
        $model->save();

        return new EquipmentResource($model);
    }

    /**
     * Удаляет мягко оборудование
     *
     * @param integer $equipment
     * @return void
     */
    public function destroy(int $equipment): JsonResource
    {
        if (Equipment::where('id', $equipment)->delete()) {
            return new EquipmentResource(['Объект ' . $equipment . ' удален']);
        }

        return new EquipmentResource(['Объект ' . $equipment . ' не найден']);
    }
}
