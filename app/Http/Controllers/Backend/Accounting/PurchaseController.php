<?php

namespace App\Http\Controllers\Backend\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Currency;
use App\Models\accountingPurchase;
use App\Models\accountingPurchasebalance;
use App\Models\table_balance;
use App\Models\table_history;
use App\Models\TableProfitOrLoss;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $currency_name = Currency::get();
        $purchased_data = accountingPurchase::get();
        return view('backend.pages.accounting.purchase.index' , ['currency_name' => $currency_name] , ['purchased_data' => $purchased_data] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currecnies = Currency::get();
        return view('backend.pages.accounting.purchase.create' , ['currecnies' => $currecnies]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    { 

        $request->validate([
            // $currecnies = Currency::allot (),
            'currency_id' => 'required|exists:currency,id',
            'qty' => 'required|numeric',
            'rate' => 'required|numeric',
            'timing' => 'required',
        ]);

        // create record for accountingPurchase

        $table_purchase_data = new accountingPurchase;
        $table_purchase_data->currency_id = $request['currency_id'];
        $table_purchase_data->qty = $request['qty'];
        $table_purchase_data->rate = $request['rate'];
        $table_purchase_data->timing = $request['timing'];
        $table_purchase_data->save();
   


        // $purchase_id
        $purchase_id = $table_purchase_data->id;

        // create record for accountingPurchasebalance
        $table_Purchasebalance= new accountingPurchasebalance();
        $table_Purchasebalance->currency_id = $request['currency_id'];
        $table_Purchasebalance->purchaseBalance = $request['qty'];
        $table_Purchasebalance->purchase_id = $purchase_id;
        $table_Purchasebalance->save();
        
        
        // create record for table_balances
        $balanceRecord = table_balance::where('currency_id', $request->currency_id)->first();
        if ($balanceRecord) {
            table_balance::updateOrCreate(
                
                ['currency_id' =>$request['currency_id']],
                ['balance' => ( $request['qty'] + $balanceRecord->balance ) ]
                
            );
        }else{
            table_balance::updateOrCreate(
                
                ['currency_id' =>$request['currency_id']],
                ['balance' =>  $request['qty']  ]
                
            );
        }
        // create record for table_history
        
        $balanceRecord_fresh = table_balance::where('currency_id', $request->currency_id)->first();
        

        $table_history_data = new table_history;
        $table_history_data->currency_id = $request['currency_id'];
        $table_history_data->trans_id = $purchase_id;
        $table_history_data->purchase_balance_id = $table_Purchasebalance->id;
        $table_history_data->trans_type = 1;
        $table_history_data->qty = $request['qty'];
        $table_history_data->balance = $balanceRecord_fresh->balance;
        $table_history_data->save();


        return redirect()->route('accountingPurchase.index');
    }

   
    public function show_accountingPurchase()
    {
        $currency_name = Currency::get();
        $purchased_data = table_balance::get();
        return view('backend.pages.accounting.purchase.accountingPurchasebalance_show',['currency_name' => $currency_name] , ['purchased_data' => $purchased_data]);
    }
    
    public function profit_loss()
    {
        $table_histories = table_history::with('currency')->get();
        $profit_losses = TableProfitOrLoss::all();
        $profit_loss_map = [];
        
        foreach ($profit_losses as $profit_loss) {
            $profit_loss_map[$profit_loss->purchase_bal_id][] = $profit_loss;
        }
        
        $matched_records = [];
        
        foreach ($table_histories as $history) {
            $purchase_balance_id = $history->purchase_balance_id;
            if (isset($profit_loss_map[$purchase_balance_id])) {
                foreach ($profit_loss_map[$purchase_balance_id] as $profit_loss) {
                    $matched_records[] = [
                        'table_history' => $history,
                        'profit_loss' => $profit_loss,
                    ];
                }
            }
        }
        
        return view('backend.pages.accounting.purchase.profit_loss', [
            'matched_records' => $matched_records,
        ]);
    }
    
    public function current_rate(){

        $currency_name = Currency::get('currency');
        $currency_names = array_column($currency_name->toArray(), 'currency');
        $currency_names_str = implode(',', $currency_names);

        $response = Http::get('https://min-api.cryptocompare.com/data/pricemulti', [
            'fsyms' => $currency_names_str,
            'tsyms' => 'USD,EUR,INR',
        ]);

        if ($response->successful()) {
            $rates =  response()->json($response->json());
        } else {
            return response()->json(['error' => 'Failed to retrieve data from API'], $response->status());
        }
       $current_rates = $rates->original;

       return view('backend.pages.accounting.purchase.current_rates', [
        'current_rates' => $current_rates,
    ]);
    }

    public function edit($id)
    {
        $purchase = accountingPurchase::findOrFail($id);
        $currency_name = Currency::get();

        // Assuming you have a view called 'editPurchase'
        return view('backend.pages.accounting.purchase.update', compact('purchase') , compact('currency_name'));
    }

    public function update(Request $request, $id)
    {
        $purchase = accountingPurchase::findOrFail($id);
        $purchase->update($request->all());
        return redirect()->route('accountingPurchase.index')->with('success', 'Purchase updated successfully');
    }

    public function destroy($id)
    {
        $purchase = accountingPurchase::findOrFail($id);
        $purchase->delete();
        return redirect()->route('accountingPurchase.index')->with('success', 'Purchase deleted successfully');
    }
}
