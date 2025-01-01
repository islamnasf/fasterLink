<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\BranchRequest;
use App\Http\Resources\BranchCollection;
use App\Models\Branch;

class BranchController extends Controller
{
    public function index($id = null)
    {
        if ($id) {
            $user = auth('user')->user();
            $branch = Branch::with('city')->where('user_id', $user->id)->where('id', $id)->first();
            return successResponse(data: BranchCollection::make($branch));
        } else {
            $user = auth('user')->user();
            $branches = Branch::with('city')->where('user_id', $user->id)->get();
            return successResponse(data: BranchCollection::collection($branches));
        }
    }

    public function store(BranchRequest $request)
    {
        $user = auth('user')->user();
        $branch = Branch::where('user_id', $user->id)->where('is_main', 1)->first();
        if ($branch) {
            return failResponse("There is already a main branch.");
        }
        $data = $request->validated();
        $data['user_id'] = $user->id;
        Branch::create($data);
        return successResponse();
    }

    public function update(BranchRequest $request, $id)
    {
        $user = auth('user')->user();
        $branch = Branch::where('id', $id)->where('user_id', $user->id)->first();
        if (!$branch) {
            return failResponse(__('messages.branch_not_found'));
        }
        if ($request->is_main) {
            $oldBranch = Branch::where('id', "!=", $branch->id)->where('user_id', $user->id)->where('is_main', 1)->first();
            if ($oldBranch) {
                return failResponse("There is already a main branch.");
            }
        }
        $data = $request->validated();
        $branch->update($data);
        return successResponse();
    }

    public function delete($id)
    {
        $user = auth('user')->user();
        $branch = Branch::where('id', $id)->where('user_id', $user->id)->first();
        if (!$branch) {
            return failResponse(__('messages.branch_not_found'));
        }
        $branch->delete();
        return successResponse();
    }
}
