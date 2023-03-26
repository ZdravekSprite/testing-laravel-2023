<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Device;
use Illuminate\Validation\Rule;

class UpdateDeviceRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return Device::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'imei' => ['string', 'max:255', Rule::unique(Device::class)->ignore($this->id)],
      'gsm' => ['nullable', 'string', 'max:255'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
}
