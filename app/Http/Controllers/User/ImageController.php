<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeleteImageRequest;
use App\Http\Requests\User\UploadImageRequest;
use App\Http\Shared\ImageService;
use App\Models\Department;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    public function uploadImages(UploadImageRequest $request)
    {
        if (count($request->id) == count($request->image)) {
            $user = auth('user')->user();
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $index => $image) {
                    $fileName = time() . $image->getClientOriginalName();
                    $location = env('APP_ENV') == 'local' ? "public/stores/{$request->type[$index]}s" : "stores/{$request->type[$index]}s";

                    $path = "storage/stores/{$request->type[$index]}s/$fileName";

                    switch ($request->type[$index]) {
                        case 'logo':
                            $store = $user->stores->firstWhere('id', $request->id[$index]);
                            if ($store) {
                                $image->storeAs($location, $fileName);
                                $store->update(['logo' => $path]);
                            }
                            break;
                        case 'cover':
                            $store = $user->stores->firstWhere('id', $request->id[$index]);
                            if ($store) {
                                $image->storeAs($location, $fileName);
                                $store->update(['cover' => $path]);
                            }
                            break;
                        case 'loyalty':
                            $store = $user->stores->firstWhere('id', $request->id[$index]);
                            if ($store) {
                                $image->storeAs($location, $fileName);
                                $old_images = $store->loyalty_images ?? [];
                                $old_images[] = $path;
                                $store->update(['loyalty_images' => $old_images]);
                            }
                            break;
                        case 'department':
                            $department = Department::find($request->id[$index]);
                            if ($department) {
                                $store = $user->stores->firstWhere('id', $department->store_id);
                                if ($store) {
                                    $image->storeAs($location, $fileName);
                                    $old_images = $department->images ?? [];
                                    $old_images[] = $path;
                                    $department->update(['images' => $old_images]);
                                }
                            }
                            break;
                        case 'profile':
                            $location = env('APP_ENV') == 'local' ? "public/profile" : "profile";
                            $path = "storage/profile/$fileName";
                            $image->storeAs($location, $fileName);
                            try {
                                // Start the transaction
                                DB::connection('mysql')->beginTransaction();
                                DB::connection('mysql_sa')->beginTransaction();
                                // Perform database operations within the transaction
                                User::on('mysql')->firstWhere('code', $user->code)->update(['image' => $path]);
                                User::on('mysql_sa')->firstWhere('code', $user->code)->update(['image' => $path]);
                                // Commit the transaction
                                DB::connection('mysql')->commit();
                                DB::connection('mysql_sa')->commit();
                            } catch (\Exception $e) {
                                // An error occurred, rollback the transaction
                                DB::connection('mysql')->rollBack();
                                DB::connection('mysql_sa')->rollBack();
                                // Handle the exception or log the error
                                Log::error('Upload Profile Image Transaction failed: ' . $e->getMessage());
                                return failResponse(__('messages.something_went_wrong'));
                            }
                            break;
                    }
                }
            }
        }
        return successResponse();
    }

    public function deleteImages(DeleteImageRequest $request)
    {
        if (count($request->id) == count($request->type)) {
            $ids = $request->id;
            foreach ($ids as $index => $id) {
                switch ($request->type[$index]) {
                    case 'logo':
                        $store = Store::find($request->id[$index]);
                        if ($store) {
                            ImageService::delete($store->logo);
                            $store->update(['logo' => null]);
                        }
                        break;
                    case 'cover':
                        $store = Store::find($request->id[$index]);
                        if ($store) {
                            ImageService::delete($store->cover);
                            $store->update(['cover' => null]);
                        }
                        break;
                    case 'loyalty':
                        $store = Store::find($request->id[$index]);
                        if ($store) {
                            $images = $store->loyalty_images;
                            $url = $request->image[$index];
                            $path = ImageService::path($url);
                            $key = array_search($path, $images);
                            if ($key === FALSE) {
                            } else {
                                ImageService::delete($path);
                                unset($images[$key]);
                                $store->update(['loyalty_images' => array_values($images)]);
                            }
                        }
                        break;
                    case 'department':
                        $department = Department::find($request->id[$index]);
                        if ($department) {
                            $images = $department->images;
                            $url = $request->image[$index];
                            $path = ImageService::path($url);
                            $key = array_search($path, $images);
                            if ($key === FALSE) {
                            } else {
                                ImageService::delete($path);
                                unset($images[$key]);
                                $department->update(['images' => array_values($images)]);
                            }
                        }
                        break;
                    case 'profile':
                        $user = auth('user')->user();
                        ImageService::delete($user->image);
                        try {
                            // Start the transaction
                            DB::connection('mysql')->beginTransaction();
                            DB::connection('mysql_sa')->beginTransaction();
                            // Perform database operations within the transaction
                            User::on('mysql')->firstWhere('code', $user->code)->update(['image' => null]);
                            User::on('mysql_sa')->firstWhere('code', $user->code)->update(['image' => null]);
                            // Commit the transaction
                            DB::connection('mysql')->commit();
                            DB::connection('mysql_sa')->commit();
                        } catch (\Exception $e) {
                            // An error occurred, rollback the transaction
                            DB::connection('mysql')->rollBack();
                            DB::connection('mysql_sa')->rollBack();
                            // Handle the exception or log the error
                            Log::error('Delete Profile Image Transaction failed: ' . $e->getMessage());
                            return failResponse(__('messages.something_went_wrong'));
                        }
                        break;
                }
            }
        }
        return successResponse();
    }
}
