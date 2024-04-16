<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    public function orders()
    {
      return $this->belongsTo(Order::class);
    }

    public function users()
    {
      return $this->belongsToMany(User::class, 'part_user');
    }

    public function carts()
    {
      return $this->belongsToMany(Cart::class, 'cart_part');
    }

    protected $fillable = ['title', 'type', 'description', 'price', 'image'];
  }
