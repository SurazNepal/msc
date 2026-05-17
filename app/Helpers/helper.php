<?php

namespace App\Helpers;

if (!function_exists('createResponse')) {
    function createResponse($status, $message)
    {
        return [
            'status' => $status,
            'message' => $message,
        ];
    }
}
if (!function_exists('dispatchSwalMessage')) {
    function dispatchSwalMessage($Component, $payload)
    {
        $Component->dispatch('swalFire', [
            'status' => $payload['status'],
            'message' => $payload['message'],
        ]);
    }
}
