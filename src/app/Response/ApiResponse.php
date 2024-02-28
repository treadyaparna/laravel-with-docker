<?php
/**
 * Created for transactions.
 * User: Aparna Saha
 * Email: tready.aparna@gmail.com
 */

namespace App\Response;

use App\Enums\HttpStatus;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * @param integer $code
     * @param string|null $msg
     * @param array|null $errors
     * @return JsonResponse
     */
    public static final function response(int $code, string $msg = null, array $errors = null)
    {
        return response()->json(array(
            'message' => $msg ?? HttpStatus::MESSAGES[$code],
            'code' => $code,
            'status_code' => $code,
            'status' => HttpStatus::MESSAGES[$code],
        ), $code);
    }

    /**
     * @param string|null $msg
     * @return JsonResponse
     */
    public static final function responseOK(string $msg = null)
    {
        return response()->json(array(
            'message' => empty($msg) ? 'OK' : $msg,
            'status_code' => HttpStatus::HTTP_OK,
            'status' => HttpStatus::MESSAGES[200],
        ), HttpStatus::HTTP_OK);
    }
}
