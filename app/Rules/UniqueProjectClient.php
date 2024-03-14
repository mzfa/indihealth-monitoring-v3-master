<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Project;

class UniqueProjectClient implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $name_client;
    private $id;
    private $val;
    public function __construct($name_client=null, $id=null)
    {
      
        $this->name_client = $name_client;
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
        return 'Anda tidak dapat menginputkan projek yang sama pada Client ini.';
    }

    private function checkLinkedProject($val)
    {
        $project = Project::where(['client' => $this->name_client,'name' => $val]);
      if(!empty($this->id))
        {
            $project->where('id','!=',$this->id);
        } 
        $count = $project->count();

        return $count == 0 ? true:false;
    }
}
