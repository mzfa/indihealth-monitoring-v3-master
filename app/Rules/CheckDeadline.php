<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\ProjectPlanDetail;

class CheckDeadline implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $id;
    private $plan_id;
    // private $date;
    public function __construct($plan_id)
    {
        // $this->id = $id;
        $this->plan_id = $plan_id;
        // $this->date = $date;
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
        if($this->checkProjectPlan($value))
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
        return 'Tidak dapat menginputkan lebih dari tanggal deadline';
    }

    private function checkProjectPlan($val)
    {
      $plan = ProjectPlanDetail::where('id',$this->plan_id)->first();

      $end = strtotime($plan->end_date);
      if(strtotime($val) > $end)
      {
        return false;
      }


        return true;
    }
}
