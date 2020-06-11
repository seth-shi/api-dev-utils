<?php


namespace SethShi\ApiDevUtils\Utils;


use Carbon\Carbon;
use Illuminate\Http\Response;

class ResponseUtil
{
    public static function responseJsonMsg($msg, $data = [], $extData = [])
    {
        return self::responseJson(Response::HTTP_OK, $msg, $data, $extData);
    }
    
    public static function responseJsonData($data = [], $extData = [])
    {
        return self::responseJson(Response::HTTP_OK, 'success', $data, $extData);
    }
    
    /**
     * Can be used to request invalid parameters
     * @param $msg
     * @param array $data
     * @param array $extData
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseJsonAsBadRequest($msg, $data = [], $extData = [])
    {
        return self::responseJson(Response::HTTP_BAD_REQUEST, $msg, $data, $extData);
    }
    
    public static function responseJsonAsNotFound($msg = 'not found', $data = [], $extData = [])
    {
        return self::responseJson(Response::HTTP_NOT_FOUND, $msg, $data, $extData);
    }
    
    public static function responseJsonAsServerError($msg, $data = [], $extData = [])
    {
        return self::responseJson(Response::HTTP_INTERNAL_SERVER_ERROR, $msg, $data, $extData);
    }
    
    public static function responseJson($code = Response::HTTP_OK, $msg = 'success', $data = [], $extData = [])
    {
        $responseData = compact('code', 'msg', 'data');
        
        $responseData = array_merge(
            [
                'response_at' => Carbon::now()->toDateTimeString(),
            ],
            $responseData
        );
        
        if (! empty($extData)) {
            
            $responseData = array_merge($extData, $responseData);
        }
        
        return response()->json($responseData, Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
