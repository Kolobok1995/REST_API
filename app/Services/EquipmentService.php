<?php

namespace App\Services;

use App\Services\Base\BaseServiceApi;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Query\Builder;
use App\Http\Resources\EquipmentResource;
use App\Traits\SearchableTrait;

class EquipmentService extends BaseServiceApi
{
    use SearchableTrait;

    private Builder $query;

    /**
     * Инициализация сервиса модели
     *
     * @return void
     */
    public function init(): void
    {
            $this->initQuery();
            $this->initSearchable();
    }

    /**
     * Инициализация билдера 
     *
     * @return void
     */
    private function initQuery(): void
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

    /**
     * Инициализация параметров поиска
     *
     * @return void
     */
    private function initSearchable(): void
    {
        $this->setSearchField('type_name', 'queryFilterByLike', 'et.name');
        $this->setSearchField('id', 'queryFilterEquality', 'e.id');
        $this->setSearchField('desc', 'queryFilterEquality', 'e.desc');
        $this->setSearchField('serial_number', 'queryFilterEquality', 'e.serial_number');
        $this->setSearchField('mask', 'queryFilterEquality', 'et.mask');
    }

    /**
     * Поиск по like %{text}%
     *
     * @param string $column
     * @param string $value при использовании как колбек в SearchableTrait передается автоматически и параметров реквеста
     * @return void
     */
    public function queryFilterByLike(string $column, string $value)
    {
        $this->query = $this->query->orWhere($column, 'like', '%' . $value . '%');
    }
    
    /**
     * Поиск по равенству 
     *
     * @param string $column
     * @param string $value при использовании как колбек в SearchableTrait передается автоматически и параметров реквеста
     * @return void
     */
    public function queryFilterEquality(string $column, string $value)
    {
        $this->query = $this->query->orWhere($column, $value);
    }

    /**
     * Выполняет Builder::get()
     *
     * @return void
     */
    public function executeGet()
    {
        $this->data = $this->query
            ->get()
            ->toArray();
    }
    
    /**
     * Выполняет Builder::get()
     *
     * @param integer $equipmentId
     * @return void
     * @throws Exception
     */
    public function executeFirstOrFail(int $equipmentId)
    {
        $this->data = (array) $this->query
            ->where('e.id', $equipmentId)
            ->first();

            //ToDo Exception
    }
}