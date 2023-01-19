<?php

namespace App\Services;

class ResponseService
{
    public function apiResponse($status,$message,$data){
        if($status == true){
            return response()->json(['status' => $status, 'message' => $message, 'data' => $data], 200);
        }else{
            return response()->json(['status' => $status, 'message' => $message], 400);
        }

    }
}
