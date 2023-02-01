<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Builder;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'desc',
    ];
    

    public function equipmentType()
    {
        return $this->hasOne(EquipmentType::class, 'id', 'type_id');
    }
}
