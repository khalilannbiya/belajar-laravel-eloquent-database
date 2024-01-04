<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function form()
    {
        return view('form');
    }

    public function login(LoginRequest $request)
    {
        $data = $request->all();
        // do something with the $data
        return response("OK", Response::HTTP_OK);
    }
}
