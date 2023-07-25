<?php

namespace App\Helpers;

class ApiResponse
{
    // static function sendResponse($code = 200, $msg = null, $data = null)
    // {
    //     $response = [
    //         'status'    => $code,
    //         'msg'       => $msg,
    //         'data'      => $data,
    //     ];
    //     return response()->json($response, $code);
    // }
    static function sendResponse($data, $msg = null, $status = 200)
    {
        return response([
            'message'=>$msg,
            'result'=>!empty($data)?$data:null,
            'statusCode'=>$status,
            'status'=>in_array($status,[200,201,202,203]),
        ],$status);
    }
}