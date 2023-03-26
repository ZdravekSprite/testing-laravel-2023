<?php

namespace App\Http\Requests;

use App\Models\Device;
use Illuminate\Foundation\Http\FormRequest;

class DestroyDeviceRequest extends FormRequest
{
  public function authorize(): bool
  {
    return Device::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  public function rules(): array
  {
    return [
      //
    ];
  }
}
