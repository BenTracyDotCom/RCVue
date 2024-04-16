<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function parts()
    {
      return $this->hasMany(Part::class);
    }

    public function users()
    {
      return $this->belongsTo(User::class);
    }
}
