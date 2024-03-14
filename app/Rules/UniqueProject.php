<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\LinkedProject;

class UniqueProject implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $guest_id;
    public function __construct($guest_id = null)
    {
        $this->guest_id = $guest_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->val = $value;
        if($this->checkLinkedProject($value))
        {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Anda tidak dapat menginputkan projek yang sama pada pengguna ini.';
    }

    private function checkLinkedProject($val)
    {
        $link = LinkedProject::where(['project_id' => $val,'guest_id' => $this->guest_id]);
    
        $count = $link->count();

        return $count == 0 ? true:false;
    }
}
