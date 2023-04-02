<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
  use HasFactory;
  protected $hidden = [
    'created_at',
    'updated_at',
  ];
  protected $fillable = [
    'name',
    'description',
  ];
  public function devices(): HasMany
  {
    return $this->hasMany(Device::class);
  }
}
