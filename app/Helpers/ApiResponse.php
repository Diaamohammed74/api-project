<?php

if (!function_exists('authApi'))
{
    function authApi()
    {
        return auth()->guard('api');
    }
}
if (!function_exists('sendResponse')) {
    function sendResponse($data, $msg = null, $status = 200)
    {
        return response([
            'message' => $msg,
            'result' => !empty($data) ? $data : null,
            'statusCode' => $status,
            'status' => in_array($status, [200, 201, 202, 203]),
        ], $status);
    }

}
