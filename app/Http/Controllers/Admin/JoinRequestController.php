<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;

class JoinRequestController extends Controller
{

    public function index()
    {
        $joinRequests = JoinRequest::orderBy('created_at','desc')->get();
        return view('panel.join_requests', compact('joinRequests'));
    }

    public function delete($id)
    {
        $joinRequest = JoinRequest::findOrFail($id);
        $joinRequest->delete();
        return back()->with('message', 'Done Successfully');
    }
}
