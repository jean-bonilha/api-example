<?php

namespace App\Traits;

trait ResponseController
{
    public function response($message, int $status)
    {
        return response()->json([
            'message' => $message
        ], $status);
    }

    public function success($message = 'success')
    {
        return $this->response($message, 200);
    }

    public function created($message = 'created')
    {
        return $this->response($message, 201);
    }

    public function badRequest($message = 'invalid request')
    {
        return $this->response($message, 400);
    }

    public function notFound($message = 'not found')
    {
        return $this->response($message, 404);
    }

    public function unprocessable($message = 'unable to be followed')
    {
        return $this->response($message, 422);
    }

    public function error($message = 'an error occurred', int $status = 500)
    {
        return $this->response($message, $status);
    }
}
