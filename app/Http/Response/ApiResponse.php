<?php

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    protected int $status;

    protected string $message;

    protected mixed $data;

    public function __construct(int $status = 200, string $message = "success", mixed $data = null)
    {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    public function toJson(): JsonResponse
    {
        $response = [
            'status' => $this->status,
            'message' => $this->message,
        ];

        if (!is_null($this->data)) {
            $response['data'] = $this->data;
        }

        return response()->json($response, $this->status);
    }
}