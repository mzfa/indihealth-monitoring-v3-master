<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\ProjectPlan;

class UniqueProjectPlan implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $project_id;
    public function __construct($project_id)
    {
        $this->project_id = $project_id;
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
        if($this->checkPlan($value))
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
        return 'Anda tidak dapat menginputkan nama plan project yang sama pada project ini.';
    }

    private function checkPlan($val)
    {
        $link = ProjectPlan::where(['project_id' => $this->project_id,'name' => $val]);

        $count = $link->count();

        return $count == 0 ? true:false;
    }
}
