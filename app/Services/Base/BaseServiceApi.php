<?php

namespace App\Services\Base;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Builder;

class BaseServiceApi
{
    protected array $errors = [];
    protected array $success = [];
    protected array $data = [];

    public function setErrors(array $errors = []): void
    {
        $this->errors = $errors;
    }

    public function setSuccess(array $success = []): void
    {
        $this->success = $success;
    }

    public function setData(array $data = []): void
    {
        $this->data = $data;
    }
    
    public function getData(): array
    {
        return $this->data;
    }

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