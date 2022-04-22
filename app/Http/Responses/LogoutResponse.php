<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use Symfony\Component\HttpFoundation\Response;

class LogoutResponse implements LogoutResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function toResponse($request)
    {
        session()->forget('session_token');
        session()->forget('access_email');
        session()->forget('access_name');
        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect(route('get.token'))->with('success', 'Logged out successfully');
    }
}