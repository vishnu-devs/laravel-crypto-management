<?php

namespace App\Http\Controllers\ApiControllers;
use App\Models\purchaseModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\accountingPurchase;


class PurchaseController extends Controller
{
    public function store(Request $request){

        $validatedData = $request->validate([
            'currency_id' => 'required|string',
            'rate' => 'required|numeric',
            'qty' => 'required|numeric',
            'timing' => 'required',
        ]);
        $model = accountingPurchase::create($validatedData);
        
        return response()->json(['message' => 'Data inserted successfully', 'data' => $model], 201);
    }
        
    public function get(){
        $data = accountingPurchase::get();

        return $data;
    }

   
}
