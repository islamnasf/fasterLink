<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DepartmentRequest;
use App\Http\Resources\DepartmentCollection;
use App\Models\Department;
use App\Models\Store;

class DepartmentController extends Controller
{

    public function index($id = null)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        if ($id) {
            $department = Department::where('store_id', $store->id)->where('id', $id)->first();
            return successResponse(data: DepartmentCollection::make($department));
        } else {
            $departments = Department::where('store_id', $store->id)->get();
            return successResponse(data: DepartmentCollection::collection($departments));
        }
    }

    public function store(DepartmentRequest $request)
    {
        $user = auth('user')->user();
        $data = $request->validated();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $data['store_id'] = $store->id;
        Department::create($data);
        return successResponse();
    }

    public function update(DepartmentRequest $request, $id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $department = Department::where('id', $id)->where('store_id', $store->id)->first();
        if (!$department) {
            return failResponse(__('messages.department_not_found'));
        }
        $data = $request->validated();
        $department->update($data);
        return successResponse();
    }

    public function delete($id)
    {
        $user = auth('user')->user();
        if (!$store = Store::firstWhere('user_id', $user->id)) {
            return failResponse(__('messages.store_not_found'));
        }
        $department = Department::where('id', $id)->where('store_id', $store->id)->first();
        if (!$department) {
            return failResponse(__('messages.department_not_found'));
        }
        $department->delete();
        return successResponse();
    }
}
