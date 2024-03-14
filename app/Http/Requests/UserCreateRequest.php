<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:\App\Models\User',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:\App\Models\Role,id',
            'karyawan_terkait' => 'nullable|exists:\App\Models\Karyawan,id',
        ];
    }
    
}
