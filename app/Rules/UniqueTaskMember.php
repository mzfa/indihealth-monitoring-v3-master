<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\TaskMember;

class UniqueTaskMember implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $user_id;
    public function __construct($user_id = null)
    {
        $this->user_id = $user_id;

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
        if($this->checkMember($value))
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

    private function checkMember($val)
    {
        $link = TaskMember::where(['user_id' => $this->user_id,'task_id' => $val]);

        $count = $link->count();

        return $count == 0 ? true:false;
    }
}
