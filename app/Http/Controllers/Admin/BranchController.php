<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchNumber;
use App\Models\Store;
use Illuminate\Http\Request;

class BranchController extends Controller

{
    public function index()
    {
        $branches = Branch::all();       
        return view('panel.branches', compact('branches'));
    }
    public function delete($id)
    {
        $branch = Branch::findOrFail($id);
        $branch->delete();
        return back()->with('message', 'Done Successfully');
    }

    public function numberDelete($id)
{
    $number = BranchNumber::findOrFail($id);
    $number->delete();

    return redirect()->back()->with('success', 'Number deleted successfully.');
}

}
