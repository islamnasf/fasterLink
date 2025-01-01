<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CategoryRequest;
use App\Http\Shared\ImageService;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();
        return view('panel.categories', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        $data['image'] = ImageService::save($request, 'categories');
        // Category::create($data);
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            // DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            Category::on('mysql')->create($data);
            // Category::on('mysql_sa')->create($data);
            // Commit the transaction
            DB::connection('mysql')->commit();
            // DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            // DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Create Category Profile Transaction failed: ' . $th->getMessage());
            return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            ImageService::delete($category->image);
            $data['image'] = ImageService::save($request, 'categories');
        }
        // Category::find($id)->update($data);
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            // DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            Category::on('mysql')->find($id)->update($data);
            // Category::on('mysql_sa')->find($id)->update($data);
            // Commit the transaction
            DB::connection('mysql')->commit();
            // DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            // DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Update Category Profile Transaction failed: ' . $th->getMessage());
            return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        ImageService::delete($category->image);
        // Category::find($id)->delete();
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            // DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            Category::on('mysql')->find($id)->delete();
            // Category::on('mysql_sa')->find($id)->delete();
            // Commit the transaction
            DB::connection('mysql')->commit();
            // DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            // DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Delete Category Transaction failed: ' . $th->getMessage());
            return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }

    public function active(Request $request, $id)
    {
        $category = Category::on('mysql')->findOrFail($id);
        // $category_sa = Category::on('mysql_sa')->findOrFail($id);

        $active = (isset($request->active) && $request->active == 'on') ? 1 : 0;
        
        $category->update(['active' => $active]);
        // $category_sa->update(['active' => $active]);
        return back()->with('message', 'Done Successfully');
    }
}
