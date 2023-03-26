<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
  use HasFactory;
  protected $hidden = [
    'created_at',
    'updated_at',
  ];
  protected $fillable = [
    'imei',
    'gsm',
    'type_id',
    'warehouse_id',
    'owner_id',
    'description',
  ];
  /**
   * Accessors.
   */
  protected $appends = ['type', 'warehouse', 'owner'];

  public function getTypeAttribute()
  {
    $type = Type::where('id',$this->type_id)->first();
    return $type->name;
  }
  public function getWarehouseAttribute()
  {
    $type = Warehouse::where('id',$this->warehouse_id)->first();
    return $type->name;
  }
  public function getOwnerAttribute()
  {
    $type = Owner::where('id',$this->owner_id)->first();
    return $type->name;
  }
  public function type(): BelongsTo
  {
    return $this->belongsTo(Type::class);
  }
}
