<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ContactUsRequest;
use App\Models\ContactUs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactUsController extends Controller
{
    public function store(ContactUsRequest $request)
    {
        $data = $request->validated();
        try {
            // Start the transaction
            DB::connection('mysql')->beginTransaction();
            DB::connection('mysql_sa')->beginTransaction();
            // Perform database operations within the transaction
            ContactUs::on('mysql')->create($data);
            ContactUs::on('mysql_sa')->create($data);
            // Commit the transaction
            DB::connection('mysql')->commit();
            DB::connection('mysql_sa')->commit();
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::connection('mysql')->rollBack();
            DB::connection('mysql_sa')->rollBack();
            // Handle the exception or log the error
            Log::error('Contact Us Transaction failed: ' . $e->getMessage());
            return failResponse(__('messages.something_went_wrong'));
        }
        return successResponse();
    }
}
