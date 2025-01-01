<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\FaqRequest;
use App\Http\Resources\FaqCollection;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(FaqRequest $request)
    {
        $faqs = Faq::where('app',$request->app)->get();
        return successResponse(data:FaqCollection::collection($faqs));
    }

}
