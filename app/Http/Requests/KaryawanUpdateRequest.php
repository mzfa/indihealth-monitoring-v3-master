<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KaryawanUpdateRequest extends FormRequest
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
            'id' => 'required|exists:\App\Models\Karyawan',
            'nip' => 'required|unique:\App\Models\Karyawan,nip,'.$this->id,
            'nama_lengkap' => 'required',
            'tempat_lahir' => 'required',
            'tipe_karyawan' => 'required|in:PART-TIME,FULL-TIME',
            'tanggal_lahir' => 'required',
            'no_telp' => 'required',
            'join_date'     => 'required|date',
            'resign_date'   => 'nullable|date|gte:join_date',
            'jabatan' => 'required|exists:\App\Models\Jabatan,id',
            'foto' => 'nullable|mimes:jpg,png,gif|max:3000',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:20000',
        ];
    }
    
}
