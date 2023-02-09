<?php

namespace App\Http\Controllers;

use \Illuminate\Http\JsonResponse;

class SecurityController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(['status' => true]);
    }
}
