<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanCreateRequest extends FormRequest
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
            'nip' => 'required|unique:\App\Models\Karyawan',
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tipe_karyawan' => 'required|in:PART-TIME,FULL-TIME',
            'tanggal_lahir' => 'required',
            'no_telp' => 'required',
            'jabatan' => 'required|exists:\App\Models\Jabatan,id',
            'foto' => 'nullable|mimes:jpg,png,gif|max:3000',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:200100',
            'join_date'     => 'required|date',
            'resign_date'   => 'nullable|date|gte:join_date',
        ];
    }
    
}
