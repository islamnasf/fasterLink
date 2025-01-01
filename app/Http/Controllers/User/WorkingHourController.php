<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\WorkingHourRequest;
use App\Http\Resources\WorkingHourCollection;
use App\Models\Branch;
use App\Models\WorkingHour;

class WorkingHourController extends Controller
{
    public function index($branch_id)
    {
        $workingHours = WorkingHour::where('branch_id', $branch_id)->get();
        return successResponse(data: WorkingHourCollection::collection($workingHours));
    }

    public function update(WorkingHourRequest $request,$branch_id)
    {
        $branch = Branch::find($branch_id);
        if (!$branch) {
            return failResponse(__('messages.branch_not_found'));
        }
        WorkingHour::where('branch_id',$branch->id)->delete();
        $workingHours = $request->validated();
        foreach ($workingHours as $data) {
            $data['branch_id'] = $branch->id;
            WorkingHour::create($data);
        }
        return successResponse();
    }

}
