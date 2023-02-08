<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $fillable = [
        'city',
        'district',
        'street',
        'street2',
        'apartment',
        'apartment_no',
        'apartment_floor',
        'phone',
        'address',
        'fullname',
        'source',
        'maps_link'
    ];

    protected $casts = [
        'created_at' => 'datetime:d.m.Y H:i'
    ];

    use HasFactory;

    public function countCityData()
    {
        return $this->where('city', $this->city)->distinct('address')->count();
    }

    public function scopeFilter($query, $filter)
    {
        if ($filter['city']) {
            $query->where('city', $filter['city']);
        }

        if ($filter['district']) {
            $query->where('district', $filter['district']);
        }

        if ($filter['street']) {
            $query->where('street', $filter['street']);
        }

        if ($filter['street2']) {
            $query->where('street2', 'like', '%'.$filter['street2'].'%');
        }

        if ($filter['fullname']) {
            $query->where('fullname', 'like', '%'.$filter['fullname'].'%');
        }

        return $query;
    }
}
