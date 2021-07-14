<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function systemErrors($e)
    {
        return response()->json([
            'status'    => false,
            'code'      => $e->getCode(),
            'message'   => $e->getMessage(),
        ]);
    }
}
