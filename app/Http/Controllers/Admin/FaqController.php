<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\FaqRequest;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FaqController extends Controller
{

    public function index(Request $request)
    {
        $faqs = Faq::where('app',$request->app)->get();
        return view('panel.faqs', compact('faqs'));
    }

    public function store(FaqRequest $request)
    {
        $data = $request->validated();
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            Faq::on('mysql')->create($data);
            Faq::on('mysql_sa')->create($data);
            // Commit the transaction
            DB::connection('mysql')->commit();
            DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Create Faq Profile Transaction failed: ' . $th->getMessage());
            return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }

    public function update(FaqRequest $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $data = $request->validated();
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            Faq::on('mysql')->find($id)->update($data);
            Faq::on('mysql_sa')->find($id)->update($data);
            // Commit the transaction
            DB::connection('mysql')->commit();
            DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Update Faq Profile Transaction failed: ' . $th->getMessage());
            return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }

    public function delete($id)
    {
        $faq = Faq::findOrFail($id);
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            Faq::on('mysql')->find($id)->delete();
            Faq::on('mysql_sa')->find($id)->delete();
            // Commit the transaction
            DB::connection('mysql')->commit();
            DB::connection('mysql_sa')->commit();
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Delete Faq Transaction failed: ' . $th->getMessage());
            return back()->withErrors('Something went wrong, please try again');
        }
        return back()->with('message', 'Done Successfully');
    }
}
