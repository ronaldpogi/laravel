<?php

namespace App\Http\Requests;

use App\Models\Role;
use App\Rules\CaseInsensitiveUniqueRule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required',new CaseInsensitiveUniqueRule(new Role(), request()->id, 'name', 'Role already exists')],
            'description' => 'string|nullable'
        ];
    }
}
