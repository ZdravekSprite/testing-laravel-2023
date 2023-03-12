<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  use HasFactory;

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'id',
    'created_at',
    'updated_at',
  ];
/*
  protected $appends = ['users'];

  public function getUsersAttribute()
  {
    return $this->belongsToMany(User::class)->get();
  }
*/
  public function users()
  {
    return $this->belongsToMany(User::class);
  }
}
