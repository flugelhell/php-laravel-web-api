<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['status' => true, 'message' => 'welcome to test page']);
    }
}
