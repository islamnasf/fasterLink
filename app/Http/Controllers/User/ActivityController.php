<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RatingRequest;
use App\Http\Resources\RatingCollection;
use App\Models\Rating;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{

    public function index(Request $request)
    {
        $activities = ['views' => 1200, 'likes'=> 1200, 'shares' => 1200, 'app_installs' => 1200, 'number_saved' => 1200, 'qr_downloads' => 1200];
        return successResponse(data: $activities);
    }
    
    // public function index(Request $request, $id)
    // {
    //     $store = Store::find($id);
    //     if ($store) {
    //         $store = $store->where('id',$id)->withCount('ratings')
    //         ->withAvg('ratings', 'rating')->first();
    //         $ratings = Rating::where('store_id', $store->id);
    //         $result = $ratings->paginate(10);
    //         return successResponse(data: [
    //             "ratings_count" => (int)$store->ratings_count,
    //             "ratings_avg" => (float)round($store->ratings_avg_rating, 2),
    //             "ratings" => RatingCollection::collection($result)
    //         ], pagination: $result);
    //     }
    //     return failResponse(__('messages.store_not_found'));
    // }

    public function store(RatingRequest $request)
    {
        $data = $request->validated();
        $user = auth('user')->user();
        $data['user_id'] = $user->id;
        $rating = Rating::create($data);
        return successResponse(__('messages.rating_success'),RatingCollection::make($rating));
    }
}
