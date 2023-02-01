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