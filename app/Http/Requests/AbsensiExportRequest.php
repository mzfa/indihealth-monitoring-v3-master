<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AbsensiExportRequest extends FormRequest
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
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }
    public function messages()
    {
        return [
            'start_date.required' => 'Tanggal awal wajib diisi',
            'end_date.required' => 'Tanggal akhir wajib diisi',
            'end_date.date' => 'Tanggal akhir harus berupa tanggal',
            'start_date.date' => 'Tanggal awal harus berupa tanggal',
            'start_date.before_or_equal' => 'Tanggal awal harus sebelum tanggal akhir',
            'end_date.after_or_equal' => 'Tanggal akhir harus sesudah tanggal awal',
        ];
    }
}
