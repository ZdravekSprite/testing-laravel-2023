<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return $this->user()->hasAnyRoles(['superadmin','admin','user']);
  }
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
   */
  public function rules(): array
  {
    return [
      'name' => ['string', 'max:255', 'unique:warehouses'],
      'description' => ['nullable', 'string', 'max:255'],
    ];
  }
}
