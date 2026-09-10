<?php

class BaseController
{
    protected function successResponse($message)
    {
        return [
            "success" => true,
            "message" => $message
        ];
    }

    protected function errorResponse($message)
    {
        return [
            "success" => false,
            "message" => $message
        ];
    }
}