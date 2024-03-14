<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Task;

class UniqueTask implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $id;
    private $project_id;
    private $date;
    public function __construct($id = null,$project_id=null,$date=null)
    {
        $this->id = $id;
        $this->project_id = $project_id;
        $this->date = $date;
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
        if($this->checkTask($value))
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
        return 'Anda sudah pernah menginputkan tugas itu.';
    }

    private function checkTask($val)
    {
        $task = Task::where(['task_name' => $val,'karyawan_id' => auth()->user()->karyawan_id,'tanggal' => $this->date]);
        if(!empty($this->id))
        {
            $task->where('id','!=',$this->id);
        } 
        if(!empty($this->project_id))
        {
            $task->where('project_id',$this->project_id);
        }
        $count = $task->count();

        return $count == 0 ? true:false;
    }
}
