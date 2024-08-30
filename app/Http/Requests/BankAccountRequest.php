<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankAccountRequest extends Request
{
    public function validate(Request $request, array $validations)
    {
        $validator = Validator::make($request->all(), $validations['rules'], $validations['messages']);

        if ($validator->fails()) {
            response()->json($validator->errors(), 404)->send();
        }
    }
}