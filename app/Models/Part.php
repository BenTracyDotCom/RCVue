<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Part extends Model
{
  // Query functions
  public function scopeAvailable($query)
  {
    return $query->where('status', 'available')->orderBy('created_at', 'desc');
  }

  // DB setup
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
