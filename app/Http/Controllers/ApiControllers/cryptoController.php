<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class cryptoController extends Controller
{
    public function store(Request $request)
    {
        // Define the custom validation rule for uppercase
        $uppercaseRule = function($attribute, $value, $fail) {
            if (strtoupper($value) !== $value) {
                $fail($attribute.' must be uppercase.');
            }
        };
        
        // Validate the request data
        $validatedData = $request->validate([
            'currency' => ['required','string', 'unique:currency,currency', $uppercaseRule , 'regex:/^[A-Z]+$/'], 
        ]);
        
        $model = Currency::create($validatedData);
    
        // Return success response
        return response()->json(['message' => 'Data inserted successfully', 'data' => $model], 201);
    }
    
}
