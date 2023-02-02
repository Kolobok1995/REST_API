<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\RulesEquipmentRequestTrait;

class EquipmentRequest extends FormRequest
{
    use RulesEquipmentRequestTrait;
    
    private array $validErrors = [];

    public function rules(): array
    {
        $data = $this->get('data');

        return [
            'data.*.equipment_type_id' => [
                'required'
            ],
            
            'data.*.equipment_type_id' => [
                function($attribute, $value, $fail) use ($data) {
                    preg_match('/data.\d/', $attribute, $matches);
                    $index = preg_replace('/data./', '', $matches[0]);

                 //   $index = array_search($value, array_column($data, 'equipment_type_id'));

                    $dataItem = $data[$index];

                    $exist = \App\Models\Equipment::where('serial_number', $dataItem['serial_number'])
                        ->where('type_id', $dataItem['equipment_type_id'])
                        ->first();
                        
                    //    dd($exist);
                    if ($exist instanceof \App\Models\Equipment) {
                        $this->validator->errors()->add(
                            $attribute,
                            'Код оборудования ' . $dataItem['serial_number'] . ' уже назначен типу ' . $exist->equipmentType->name
                        );
                    }
                }
            ],
            'data.*.serial_number' => [
                'required'
            ],
            'data.*.serial_number' => [
                $this->serialNumber($data)
            ],
        ];
    }
    
    public function messages():array
    {
        return [
            'data.*.equipment_type_id' => 'equipment_type_id необходимо заполнить',
            'data.*.ss' => 'efdfsdf',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $this->validErrors = $errors->getMessages();
    }

    public function getErrors()
    {
        return $this->validErrors;
    }
    
    public function getSuccess(): array
    {
        $data = $this->get('data');

        foreach ($this->validator->errors()->getMessages() as $key=>$error) {
            preg_match('/data.\d/', $key, $matches);
            $index = preg_replace('/data./', '', $matches[0]);
            unset($data[$index]);
        }

        return $data;
    }
}