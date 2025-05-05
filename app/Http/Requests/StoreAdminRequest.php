<?php

namespace App\Http\Requests;

use App\Enums\EmployeeRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => ['required', 'string', 'max:255'],
            'phone'     => ['required', Rule::unique('admins','phone')->whereNull('deleted_at')],
            'email'     => ['required', 'string', 'email',Rule::unique('admins', 'email')->whereNull('deleted_at')],
            'password'  => ['required', 'string', 'min:6', 'max:255', 'confirmed'],
            'password_confirmation' => ['required', 'same:password'],
            'photo'  => ['bail', 'nullable', 'file', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf', 'max:4096'],
            'role' => ['required', 'in:' . implode(',', array_keys(EmployeeRole::values()))],
        ];
    }
}
