<?php 

namespace App\Traits;

use App\Models\EquipmentType;

trait RulesEquipmentRequestTrait
{
    /**
     * Проверка типа оборудования
     *
     * @param array $data
     * @return void
     */
    private function equipmentType(array $data)
    {
        return function($attribute, $value, $fail) use ($data) {
            $index = $this->getIndexData($attribute);

            $dataItem = $data[$index];

            $exist = \App\Models\Equipment::where('serial_number', $dataItem['serial_number'])
                ->where('type_id', $dataItem['equipment_type_id'])
                ->first();
            if ($exist instanceof \App\Models\Equipment) {
                $this->validator->errors()->add(
                    $attribute,
                    'Код оборудования ' . $dataItem['serial_number'] . ' уже назначен типу ' . $exist->equipmentType->name
                );
            }
        };
    }

    /**
     * Проверка серийного номера 
     *
     * @param array $data
     * @return void
     */
    private function serialNumber(array $data)
    {
        return function($attribute, $value, $fail) use ($data) {
            $index = $this->getIndexData($attribute);
            $dataItem = $data[$index];

            try {
                $mask = EquipmentType::where('id', $dataItem['equipment_type_id'])->value('mask');
            } catch (\Exception $e) {
                return;
            }
            
            if (! $mask) {
                $this->validator->errors()->add($attribute,'Идентификатор оборудования ' . $data[$index]['equipment_type_id'] . ' не найден');
                return;
            }

            $patternList = [];

            foreach (str_split($mask) as $char) {
                $patternList[] = match ($char) {
                    'N' => '([0-9])',
                    'A' => '([A-Z])',
                    'a' => '([a-z])',
                    'X' => '([A-Z]|[0-9])',
                    'Z' => '(@|-|_)'
                };
            }

            $pattern = '^' . implode($patternList) . '$';

            if(! mb_ereg_match($pattern, $value)) {
                $fail($value . ' не соответствует маске: ' . $mask);
            }
        };
    }

    /**
     * Возвращает индекс передаваемой даты
     *
     * @param string $key
     * @return integer
     */
    protected function getIndexData(string $key): int
    {
        preg_match('/data.\d/', $key, $matches);
        $index = preg_replace('/data./', '', $matches[0]);
        
        return $index;
    }
}