<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreComboItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'uuid' => ['sometimes', 'uuid', 'unique:combo_table,uuid'],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
