 <?php

if (!function_exists('sendSuccessResponse')) {
    function sendSuccessResponse($message, $data)
    {
        $response = [
            'status' => true,
            'message' => $message,
            'data'    => $data,
        ];
        return response()->json($response, 200);
    }
}

if (!function_exists('sendErrorResponse')) {
    function sendErrorResponse($message, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }
}
