<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Warehouse;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return Warehouse::find($this->id) && $this->user()->hasAnyRole('superadmin');
  }
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', Rule::unique(Warehouse::class)->ignore($this->id)],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
}
