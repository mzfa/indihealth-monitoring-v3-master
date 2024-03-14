<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketingRequest extends FormRequest
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
          'judul' => 'required',
          'project_id' => 'required|exists:\App\Models\Project,id',
          'division_id' => 'required|exists:\App\Models\TargetTicketingDivision,id',
          'site_address' => 'required',
          'kronologi' => 'required',
          'img' => 'required|mimes:jpg,png,gif|max:4000',
      ];
    }
}
