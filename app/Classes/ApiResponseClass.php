<?php

namespace App\Classes;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;
class ApiResponseClass
{
    public static function rollback($ex, $message ="Something went wrong! Process not completed"){
        DB::rollBack();
        throw new HttpResponseException(response()->json(["error" => $ex->getMessage(), "message"=> $message], 405));
    }

    public static function throw($ex, $message ="Something went wrong! Process not completed"){
        Log::info($ex);
        throw new HttpResponseException(response()->json(["error" => $ex->getMessage(), "message"=> $message], 500));
    }

    public static function sendResponse($result, $message, $code=200){
        $response=[
            'success' => true,
            'data'    => $result
        ];
        if(!empty($message)){
            $response['message'] = $message;
        }
        return response()->json($response, $code);
    }

}