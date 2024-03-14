<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectPlanDetailSelect extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $dl =[];
        $dataList = $this->projectPlanDetailSrc();
        // dd($dataList);
        foreach($dataList as $plan)
        {
            $dl[] = ['id' => $plan->id,'text' => $plan->name];
        }
            return [
                    'id' => null,
                    'text' => $this->name,
                    'children' => $dl,
                    // 'element' => "#select-plan-cat",
            ];
    }
}
