<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    public function countCityData()
    {
      return $this->where("city", $this->city)->distinct('address')->count();
    }
}
