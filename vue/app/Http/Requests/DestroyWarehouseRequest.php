<?php

namespace App\Http\Requests;

use App\Models\Warehouse;
use Illuminate\Foundation\Http\FormRequest;

class DestroyWarehouseRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Warehouse::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
