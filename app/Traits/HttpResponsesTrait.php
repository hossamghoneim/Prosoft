<?php

namespace App\Traits;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

trait HttpResponsesTrait
{
    protected function success($message, $data = [], $status = ResponseAlias::HTTP_OK): Response
    {
        $response = [
            'message' => __($message),
            'data' => $data,
        ];

        if ( !is_array($data) && $data?->additional )
            $response['meta'] = $data->additional;

        return response($response, $status);
    }

    protected function validationError($errors, $status = ResponseAlias::HTTP_UNPROCESSABLE_ENTITY): Response
    {
        return response($errors, $status);
    }


    protected function serverError($message,$errors = [], $status = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR): Response
    {
        return response([
            'message' => __($message),
            'errors' => $errors,
        ], $status);
    }

    protected function notFoundError($message,$errors=[], $status = ResponseAlias::HTTP_NOT_FOUND): Response
    {
        return response([
            'message' => __($message),
            'errors' => $errors,
        ], $status);
    }

    protected function tooManyRequest($message,$errors=[], $status = ResponseAlias::HTTP_TOO_MANY_REQUESTS): Response
    {
        return response([
            'message' => __($message),
            'errors' => $errors,
        ], $status);
    }
}
