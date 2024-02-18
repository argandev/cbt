<?php

namespace App\Hellpers;

use Illuminate\Http\Response;

final class ApiResponse
{
    public const HTTP_OK = 200;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_NOT_AUTHORIZE = 401;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_SERVER_ERROR = 500;
    public const HTTP_NOT_FOUND = 404;

    /**
     * Undocumented function
     *
     * @param string $message
     * @return Response
     */
    public static function accept(
        string $message = ''
    ): Response {
        return response([
            'error' => false,
            'message' => $message,
        ], self::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
    /**
     * Undocumented function
     *
     * @param string $message
     * @param array $data
     * @return Response
     */
    public static function acceptWithData(
        string $message = '',
        array $data = []
    ): Response {
        return response([
            'error' => false,
            'message' => $message,
            'data' => $data,
        ], self::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
    /**
     * Undocumented function
     *
     * @param string $message
     * @param array $data
     * @return Response
     */
    public static function badRequest(string $message = '', $data = []): Response
    {
        return response([
            'error' => true,
            'message' => $message,
        ], self::HTTP_BAD_REQUEST, [
            'Content-Type' => 'application/json',
        ]);
    }
    /**
     * Undocumented function
     *
     * @param string $message
     * @return Response
     */
    public static function notFound(string $message = ''): Response
    {
        return response([
            'error' => true,
            'message' => $message,
        ], self::HTTP_NOT_FOUND, [
            'Content-Type' => 'application/json',
        ]);
    }
    /**
     * Undocumented function
     *
     * @param string $message
     * @return Response
     */
    public static function forbidden(string $message = ''): Response
    {
        return response([
            'error' => true,
            'message' => $message,
        ], self::HTTP_FORBIDDEN, [
            'Content-Type' => 'application/json',
        ]);
    }
    /**
     * Undocumented function
     *
     * @param array $data
     * @param [type] $status
     * @return Response
     */
    public function custom(array $data = [], int $status = self::HTTP_OK): Response
    {
        return response($data, $status, [
            'Content-Type' => 'application/json',
        ]);
    }
}
