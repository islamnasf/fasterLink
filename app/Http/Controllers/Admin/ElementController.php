<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Element;
use Illuminate\Http\Request;

class ElementController extends Controller
{
        // عرض العناصر
        public function index()
        {
            $elements = Element::all();
            return view('panel.elements', compact('elements'));
        }
    
        // تخزين عنصر جديد
        public function store(Request $request)
        {
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
            ]);
    
            Element::create([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ]);
    
            return redirect()->back()->with('message', 'Element created successfully');
        }
    
        // تحديث عنصر موجود
        public function update(Request $request, $id)
        {
            $element = Element::findOrFail($id);
    
            $request->validate([
                'name_en' => 'required|string|max:255',
                'name_ar' => 'required|string|max:255',
            ]);
    
            $element->update([
                'name_en' => $request->name_en,
                'name_ar' => $request->name_ar,
            ]);
    
            return redirect()->back()->with('message', 'Element updated successfully');
        }
    
        // حذف عنصر
        public function delete($id)
        {
            $element = Element::findOrFail($id);
            $element->delete();
    
            return redirect()->back()->with('message', 'Element deleted successfully');
        }
}
