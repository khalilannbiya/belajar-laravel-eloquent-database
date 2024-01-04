<?php

namespace Tests\Feature;

use Closure;
use Tests\TestCase;
use App\Rules\Uppercase;
use App\Rules\RegistrationRule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\Validator as ValidationValidator;

class ValidationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testValidationValid(): void
    {
        $data = [
            "username" => "syeichkhalil",
            "password" => "123456789"
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $validator = Validator::make($data, $rules);
        self::assertFalse($validator->fails());
        self::assertTrue($validator->passes());
    }

    public function testValidationInvalid(): void
    {
        $data = [
            "username" => "",
            "password" => ""
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];


        $validator = Validator::make($data, $rules);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidationInvalidWithCustomMessages(): void
    {
        $data = [
            "username" => "",
            "password" => ""
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $messages = [
            "username.required" => "Username harus diisi!",
            "password.required" => "Password harus diisi!"
        ];

        $validator = Validator::make($data, $rules, $messages);
        self::assertTrue($validator->fails());
        self::assertFalse($validator->passes());

        $message = $validator->getMessageBag();
        Log::info($message->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidationException()
    {
        $data = [
            "username" => "",
            "password" => ""
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];

        $messages = [
            "username.required" => "Username harus diisi!",
            "password.required" => "Password harus diisi!"
        ];

        $validator = Validator::make($data, $rules, $messages);

        try {
            $validator->validate();
            self::fail('ValidationException not thrown');
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidationMultipleRules()
    {
        $data = [
            "username" => "admin",
            "password" => "rahasia"
        ];

        $rules = [
            "username" => "required|email|max:100",
            "password" => ["required", "min:6", "max:20"]
        ];

        $validator = Validator::make($data, $rules);
        self::assertTrue($validator->fails());
        Log::info($validator->errors()->toJson(JSON_PRETTY_PRINT));
    }

    public function testValidationValidData()
    {
        $data = [
            "username" => "khalilannbiya",
            "password" => "rahasia",
            "admin" => true
        ];

        $rules = [
            "username" => "required",
            "password" => "required"
        ];


        $validator = Validator::make($data, $rules);

        try {
            $result = $validator->validate();
            self::assertNotNull($result);
            Log::info(json_encode($result, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->getMessage());
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidationAdditionalValidation()
    {
        $data = [
            "username" => "khalil@gmail.com",
            "password" => "khalil@gmail.com",
        ];

        $rules = [
            "username" => "required|email|max:100",
            "password" => "required|min:6|max:20"
        ];


        $validator = Validator::make($data, $rules);
        $validator->after(function (\Illuminate\Validation\Validator $validator) {
            $data = $validator->getData();
            if ($data['username'] == $data['password']) {
                $validator->errors()->add('password', 'Password tidak boleh sama dengan Username');
            }
        });

        try {
            $result = $validator->validate();
            self::assertNotNull($result);
            Log::info(json_encode($result, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            self::assertNotNull($exception->getMessage());
            self::assertNotNull($exception->validator);
            $message = $exception->validator->errors();
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testValidationCustomRuleValidation()
    {
        $data = [
            "username" => "khalil@gmail.com",
            "password" => "khal",
        ];

        $rules = [
            "username" => ["required", "email", "max:100", new Uppercase()],
            "password" => ["required", "min:6", "max:20"]
        ];


        $validator = Validator::make($data, $rules);
        try {
            $result = $validator->validate();
            self::assertNotNull($result);
            Log::info(json_encode($result, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            $message = $exception->validator->errors();
            self::assertNotNull($message);
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testCustomRuleRegistrationRule()
    {
        $data = [
            "username" => "khalil@gmail.com",
            "password" => "khalil@gmail.com",
        ];

        $rules = [
            "username" => ["required", "email", "max:100", new Uppercase()],
            "password" => ["required", "min:6", "max:20", new RegistrationRule()]
        ];


        $validator = Validator::make($data, $rules);
        try {
            $result = $validator->validate();
            self::assertNotNull($result);
            Log::info(json_encode($result, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            $message = $exception->validator->errors();
            self::assertNotNull($message);
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function  testCustomFunctionRule()
    {
        $data = [
            "username" => "khalil@gmail.com",
            "password" => "khal",
        ];

        $rules = [
            "username" => ["required", "email", "max:100", function (string $attribute, mixed $value, Closure $fail) {
                if ($value !== strtoupper($value)) {
                    $fail("The $attribute must be UPPERCASE");
                }
            }],
            "password" => ["required", "min:6", "max:20"]
        ];


        $validator = Validator::make($data, $rules);
        try {
            $result = $validator->validate();
            self::assertNotNull($result);
            Log::info(json_encode($result, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            $message = $exception->validator->errors();
            self::assertNotNull($message);
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testRuleClass()
    {
        $data = [
            "username" => "khalil@gmail.com",
            "password" => "khal",
        ];

        $rules = [
            "username" => ["required", "email", "max:100"],
            "password" => ["required", Password::min(6)->letters()->numbers()->symbols()]
        ];


        $validator = Validator::make($data, $rules);
        try {
            $result = $validator->validate();
            self::assertNotNull($result);
            Log::info(json_encode($result, JSON_PRETTY_PRINT));
        } catch (ValidationException $exception) {
            $message = $exception->validator->errors();
            self::assertNotNull($message);
            Log::info($message->toJson(JSON_PRETTY_PRINT));
        }
    }

    public function testNestedArrayValidation()
    {
        $data = [
            "name" => [
                "first" => "Syeich",
                "last" => "Khalil"
            ],
            "address" => [
                "street" => "Jl. Mangga",
                "city" => "Karawang",
                "country" => "Indonesia"
            ]
        ];

        $rules = [
            "name.first" => ["required", "max:50"],
            "name.last" => ["max:100"],
            "address.street" => ["max:200"],
            "address.city" => ["required", "max:100"],
            "address.country" => ["required", "max:100"],
        ];

        $validator = Validator::make($data, $rules);
        self::assertTrue($validator->passes());
    }

    public function testIndexedArrayValidation()
    {
        $data = [
            "name" => [
                "first" => "Syeich",
                "last" => "Khalil"
            ],
            "address" => [[
                "street" => "Jl. Mangga",
                "city" => "Karawang",
                "country" => "Indonesia"
            ], [
                "street" => "Jl. Jambu",
                "city" => "Jakarta",
                "country" => "Indonesia"
            ]]
        ];

        $rules = [
            "name.first" => ["required", "max:50"],
            "name.last" => ["max:100"],
            "address.*.street" => ["max:200"],
            "address.*.city" => ["required", "max:100"],
            "address.*.country" => ["required", "max:100"],
        ];

        $validator = Validator::make($data, $rules);
        self::assertTrue($validator->passes());
    }
}
