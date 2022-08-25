<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait Response
{
    private $_success = "success";
    private $_failed = "fail";

    /**
     * @param $msg
     * @param $statusCode
     * @return JsonResponse
     */
    public function returnError($message, $statusCode): JsonResponse
    {
        return response()->json([
            "status" => $this->_failed,
            "message" => $message
        ], $statusCode);
    }

    /**
     * @param $msg
     * @param int $statusCode
     * @return JsonResponse
     */
    public function returnSuccessMessage($message, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            "status" => $this->_success,
            "message" => $message
        ], $statusCode);
    }

    /**
     * @param $key
     * @param $data
     * @param string $msg
     * @param int $statusCode
     * @return JsonResponse
     */
    public function returnData($key, $data, string $message = "", int $statusCode = 200): JsonResponse
    {
        return response()->json([
            "status" => $this->_success,
            "message" => $message,
            $key => $data,
        ], $statusCode);
    }

    public function returnValidationError($validator): JsonResponse
    {
        return $this->returnError($validator->errors()->first(), 400);
    }

}
