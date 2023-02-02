<?php 

namespace App\Traits;

use App\Models\EquipmentType;

trait RulesEquipmentRequestTrait
{
    private function serialNumber(array $data)
    {
        return function($attribute, $value, $fail) use ($data){
            preg_match('/data.\d/', $attribute, $matches);
            $index = preg_replace('/data./', '', $matches[0]);
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
}