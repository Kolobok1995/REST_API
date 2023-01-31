<?php

namespace App\Services\Base;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;
use stdClass;

class BaseServiceApi
{
    protected array $errors = [];
    protected array $success = [];
    protected array $data = [];

    /**
     * Устанавливаем массив ошибок
     *
     * @param array $errors
     * @return void
     */
    public function setErrors(array $errors = []): void
    {
        $this->errors = $errors;
    }

    /**
     * Массив удачных экземпляров
     *
     * @param array $success
     * @return void
     */
    public function setSuccess(array $success = []): void
    {
        $this->success = $success;
    }

    /**
     * устанавливаем массив ответа
     *
     * @param array $data
     * @return void
     */
    public function setData(array $data = []): void
    {
        $this->data = $data;
    }
    
    /**
     * Получаем массив ответа
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
    
    /**
     * возвращаем дату как объект
     *
     * @return stdClass
     */
    public function getDataObject(): stdClass
    {
        return (object) $this->data;
    }

    /**
     * Возвращает общий результат 
     *
     * @return array
     */
    public function getResult(): array
    {
        $result = [];

        if (count($this->errors)) {
            $result['errors'] = $this->errors;
        }
        
        if (count($this->success)) {
            $result['success'] = $this->success;
        }

        if (count($this->data)) {
            $result['data'] = $this->data;
        }

        return $result;
    }
}