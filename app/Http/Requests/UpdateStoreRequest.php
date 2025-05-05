<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreRequest extends FormRequest
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
        $id = $this->route('store')->id;
        return [
            'logo'  => ['bail', 'nullable', 'file', 'mimes:jpg,jpeg,png,bmp,gif,svg,webp,pdf', 'max:4096'],
            'name' => ['required', 'string', 'max:255', Rule::unique('stores','name')->ignore($id)],
        ];
    }
}
