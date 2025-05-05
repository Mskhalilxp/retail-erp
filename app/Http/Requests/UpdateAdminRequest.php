<?php

namespace App\Http\Requests;

use App\Enums\EmployeeRole;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{

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
        $id = $this->route('admin')->id;

        return [
            'name'     => ['required', 'string', 'max:255'],
            'phone'    => ['required', Rule::unique('admins','phone')->whereNull('deleted_at')->ignore($id)],
            'email'    => ['required', 'string', 'email',Rule::unique('admins', 'email')->whereNull('deleted_at')->whereNot('id',$id)],
            'password' => ['nullable', 'exclude_if:password,null', 'string', 'min:6', 'max:255', 'confirmed'],
            'password_confirmation' => ['nullable', 'exclude_if:password_confirmation,null', 'same:password'],
            'photo'  => ['bail', 'nullable', 'file', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf', 'max:4096'],
            'role' => ['required', 'in:' . implode(',', array_keys(EmployeeRole::values()))],
        ];
    }
}
