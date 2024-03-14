<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\ProjectMember;

class UniqueProjectMember implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $user_id;
    private $id;
    private $val;
    public function __construct($user_id=null, $id=null)
    {

        $this->user_id = $user_id;
        $this->id = $id;
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
        return 'Anda sudah menambahkan pengguna ini.';
    }

    private function checkLinkedProject($val)
    {
        $project = ProjectMember::where(['user_id' => $this->user_id,'project_id' => $val]);
        $count = $project->count();

        return $count == 0 ? true:false;
    }
}
