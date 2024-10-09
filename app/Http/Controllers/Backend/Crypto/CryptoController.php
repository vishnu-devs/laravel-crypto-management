<?php

namespace App\Http\Controllers\Backend\Crypto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CryptoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Currency::all();
        return view('backend.pages.crypto.index', ['data' => $data]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.crypto.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $uppercaseRule = function($attribute, $value, $fail) {
            if (strtoupper($value) !== $value) {
                $fail($attribute . ' must be uppercase.');
            }
        };

        $request->validate([
            'currency' => ['required', 'string', 'unique:currency,currency', $uppercaseRule, 'regex:/^[A-Z]+$/']
        ]);

        Currency::create($request->only('currency'));
        return redirect()->route('crypto.index')->with('success', 'Currency added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $currency = Currency::find($id);

        if (!$currency) {
            return redirect()->route('crypto.index')->with('error', 'Record not found.');
        }

        return view('backend.pages.crypto.edit', compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        $currency = Currency::find($id);

        if (!$currency) {
            return redirect()->route('crypto.index')->with('error', 'Record not found.');
        }

        $uppercaseRule = function($attribute, $value, $fail) {
            if (strtoupper($value) !== $value) {
                $fail($attribute . ' must be uppercase.');
            }
        };

        $request->validate([
            'currency' => ['required', 'string', 'unique:currency,currency,' . $id, $uppercaseRule, 'regex:/^[A-Z]+$/'],
            'status' => ['required', 'in:0,1'] // Ensure status is either 0 or 1
        ]);

        $currency->update([
            'currency' => $request->currency,
            'status' => $request->status
        ]);

        return redirect()->route('crypto.index')->with('success', 'Record updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $currency = Currency::find($id);

        if (!$currency) {
            return redirect()->route('crypto.index')->with('error', 'Record not found.');
        }

        $currency->delete();
        return redirect()->route('crypto.index')->with('success', 'Record deleted successfully.');
    }

    public function updateStatus(Request $request)
    {
        $item = Currency::find($request->id);

        if ($item) {
            $item->status = $request->status;
            $item->save();

            return response()->json(['message' => 'Status updated successfully']);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }
}


