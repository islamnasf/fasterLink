<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;

class ContactUsController extends Controller
{

    public function index()
    {
        $ContactUs = ContactUs::orderBy('created_at','desc')->get();
        return view('panel.contact_us', compact('ContactUs'));
    }

    public function delete($id)
    {
        $ContactUs = ContactUs::findOrFail($id);
        $ContactUs->delete();
        return back()->with('message', 'Done Successfully');
    }
}
