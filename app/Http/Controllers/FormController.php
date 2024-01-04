<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class FormController extends Controller
{
    public function login(Request $request)
    {
        try {
            $data = $request->validate([
                "username" => ["required"],
                "password" => ["required", Password::min(6)->numbers()->letters()->symbols()]
            ]);

            // do something with the $data
            return response("OK", Response::HTTP_OK);
        } catch (ValidationException $exception) {
            Log::error(json_encode($exception->errors(), JSON_PRETTY_PRINT));
            return response($exception->errors(), Response::HTTP_BAD_REQUEST);
        }
    }
}
