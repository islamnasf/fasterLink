<?php

if (! function_exists('failResponse')) {
    function failResponse($message = null, $data = null)
    {
        return response()->json(['status'=>false,'message'=>$message??'Something went wrong','data'=>$data]);
    }
}

if (! function_exists('successResponse')) {
    function successResponse($message = null, $data = null,$pagination=null)
    {
        if ($pagination) {
            return response()->json([
            'status'=>true,
            'message'=>$message??__('messages.done_successfully'),
            'total_pages'=>$pagination->lastPage(),
            'current_page'=>$pagination->currentPage(),
            'per_page'=>$pagination->perPage(),
            'items_count'=>$pagination->total(),
            'data'=>$data]);
        }else {
            return response()->json(['status'=>true,'message'=>$message??__('messages.done_successfully'),'data'=>$data]);
        }
    }
}