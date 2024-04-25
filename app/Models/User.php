<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{

  public function getSavedParts(){
    // This uses the relationship method we fefine below
    return $this->parts;
  }

    use HasFactory, Notifiable;
 
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'username',
      'email',
      'password',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
      'password',
      'remember_token',
    ];
    
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
      return [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
      ];
    }
    
    public function orders()
    {
      return $this->hasMany(Order::class);
    }
    
    public function carts() 
    {
      return $this->hasOne(Cart::class);
    }
    
    public function parts()
    {
      return $this->belongsToMany(Part::class, 'part_user');
    }
    public function roles(): BelongsToMany
    {
      return $this->belongsToMany(Role::class);
    }
  }
  