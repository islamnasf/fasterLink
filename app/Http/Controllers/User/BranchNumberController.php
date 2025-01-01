<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BranchNumberRequest;
use App\Http\Resources\BranchNumberCollection;
use App\Models\Branch;
use App\Models\BranchNumber;
use Illuminate\Http\Request;

class BranchNumberController extends Controller
{
    public function index(Request $request,$branch_id)
    {
        $branchNumbers = BranchNumber::where('branch_id', $branch_id)->where('type', $request->type)->get();
        return successResponse(data: BranchNumberCollection::collection($branchNumbers));
    }

    public function store(BranchNumberRequest $request, $branch_id)
    {
        $branch = Branch::find($branch_id);
        if (!$branch) {
            return failResponse(__('messages.branch_not_found'));
        }

        $data = $request->all();
        foreach ($data as $item) {
            $item['branch_id'] = $branch->id;
            BranchNumber::create($item);
        }

        return successResponse();
    }

    public function update(BranchNumberRequest $request, $branch_id, $id)
    {
        $branch = Branch::find($branch_id);
        if (!$branch) {
            return failResponse(__('messages.branch_not_found'));
        }
        $BranchNumber = BranchNumber::where('id', $id)->where('branch_id', $branch->id)->first();
        if (!$BranchNumber) {
            return failResponse(__('messages.branch_number_not_found'));
        }
        $data = $request->validated();
        $BranchNumber->update($data);
        return successResponse();
    }

    public function delete($branch_id, $id)
    {
        $branch = Branch::find($branch_id);
        if (!$branch) {
            return failResponse(__('messages.branch_not_found'));
        }
        $BranchNumber = BranchNumber::where('id', $id)->where('branch_id', $branch->id)->first();
        if (!$BranchNumber) {
            return failResponse(__('messages.branch_number_not_found'));
        }
        $BranchNumber->delete();
        return successResponse();
    }
}
