<?php

namespace App\Http\Controllers\Backend\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;
use App\Models\accountingPurchase;
use App\Models\AccountingSale;
use App\Models\accountingPurchasebalance;
use App\Models\table_balance;
use App\Models\table_history;
use App\Models\TableProfitOrLoss;


class SaleController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $currency_name = Currency::get();
        $sale_data = AccountingSale::get();
        return view('backend.pages.accounting.sale.index' , ['currency_name' => $currency_name] , ['sale_data' => $sale_data] );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currecnies = Currency::get();
        return view('backend.pages.accounting.sale.create' , ['currecnies' => $currecnies]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'currency_id' => 'required|exists:currency,id',
        'qty' => 'required|numeric',
        'rate' => 'required|numeric',
        'timing' => 'required',
    ]);

    $currency_id = $request['currency_id'];

    // Create record for AccountingSale
    $table_sale_data = new AccountingSale;
    $table_sale_data->currency_id = $currency_id;
    $table_sale_data->qty = $request['qty'];
    $table_sale_data->rate = $request['rate'];
    $table_sale_data->timing = $request['timing'];
    $table_sale_data->save();

    $sale_id = $table_sale_data->id;

    // Update table_balance
    $balanceRecord = table_balance::where('currency_id', $currency_id)->first();
    if ($balanceRecord) {
        $balanceRecord->balance -= $request['qty'];
        $balanceRecord->save();
    }

    // Find the purchase balance records
    $purchasebalanceIds = AccountingPurchasebalance::where('currency_id', $currency_id)
        ->where('purchaseBalance', '>', 0)
        ->orderBy('created_at', 'asc')
        ->get();

    $required_qty = $request['qty'];
    $purchase_ids = [];

    foreach ($purchasebalanceIds as $purchasebalanceId) {
        if ($required_qty <= 0) {
            break;
        }

        $current_purchase_id_bal = $purchasebalanceId->purchaseBalance;

        if ($current_purchase_id_bal <= $required_qty) {
            // Fully utilize this purchase balance
            $this->insert_into_profit_loss($sale_id, $purchasebalanceId->purchase_id, $purchasebalanceId->id, $current_purchase_id_bal);

            $required_qty -= $current_purchase_id_bal;
            $purchasebalanceId->purchaseBalance = 0;
            $purchasebalanceId->save();

            $purchase_ids[] = $purchasebalanceId->id;
        } else {
            // Partially utilize this purchase balance
            $this->insert_into_profit_loss($sale_id, $purchasebalanceId->purchase_id, $purchasebalanceId->id, $required_qty);

            $purchasebalanceId->purchaseBalance -= $required_qty;
            $purchasebalanceId->save();

            $purchase_ids[] = $purchasebalanceId->id;
            $required_qty = 0;
        }
    }

    if ($required_qty > 0) {
        throw new \Exception("Not enough purchase quantity to fulfill the sale quantity.");
    }

    $balanceRecord_fresh = table_balance::where('currency_id', $currency_id)->first();
    $purchase_balance_id = serialize($purchase_ids);

    // Create record for table_history
    $table_history_data = new table_history;
    $table_history_data->currency_id = $currency_id;
    $table_history_data->trans_id = $sale_id;
    $table_history_data->purchase_balance_id = $purchase_balance_id;
    $table_history_data->trans_type = 2;
    $table_history_data->qty = $request['qty'];
    $table_history_data->balance = $balanceRecord_fresh->balance;
    $table_history_data->save();

    return redirect()->route('accountingSale.index');
}

public function insert_into_profit_loss($sale_id, $purchase_id, $purchasebalanceId, $qty)
{
    // Find the purchase record
    $purchase = accountingPurchase::find($purchase_id);

    if (!$purchase) {
        throw new \Exception("Purchase record not found.");
    }

    $purchase_rate = $purchase->rate;

    // Fetch sale rate and quantity from the AccountingSale model
    $sale = AccountingSale::find($sale_id);

    if (!$sale) {
        throw new \Exception("Sale record not found.");
    }

    $sale_rate = $sale->rate;

    // Calculate the difference and profit/loss based on the quantity sold
    $difference = ($sale_rate - $purchase_rate) * $qty;

    // Determine profit_or_loss
    $profit_or_loss = 2; // Default to 2 (no change)
    if ($difference > 0) {
        $profit_or_loss = 1; // Profit
        // $difference = $difference * 0.70;
    } elseif ($difference < 0) {
        $profit_or_loss = 0; // Loss
    }

    // Insert into table_profit_or_loss model
    TableProfitOrLoss::create([
        'sale_id' => $sale_id,
        'purchase_id' => $purchase_id,
        'purchase_bal_id' => $purchasebalanceId,
        'purchase_rate' => $purchase_rate,
        'sale_rate' => $sale_rate,
        'qty' => $qty, // Store the quantity sold
        'difference' => abs($difference),
        'profit_or_loss' => $profit_or_loss
    ]);
}
    
    public function getCurrencyBalance()
    {
        // You can now use $id to fetch the currency balance or perform any other logic
        
        // For example, fetch the currency balance from the database
        $id = $_POST['currency_id'];

            $purchaseBalanceRecord = table_balance::where('currency_id', $id)
            ->first();
        
        if ($purchaseBalanceRecord) {
            // Return the purchase balance or any other required data
            return response()->json([
                'success' => true,
                'purchaseBalance' => $purchaseBalanceRecord->balance,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'purchaseBalance' => "0",
                // 'message' => 'No record found with the specified criteria.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sale = accountingSale::findOrFail($id);
        $currency_name = Currency::get();

        // Assuming you have a view called 'editSale'
        return view('backend.pages.accounting.sale.update', compact('sale') , compact('currency_name'));
    }

    public function update(Request $request, $id)
    {
        $sale = accountingSale::findOrFail($id);
        $sale->update($request->all());
        return redirect()->route('accountingSale.index')->with('success', 'Sale updated successfully');
    }

    public function destroy($id)
    {
        $sale = accountingSale::findOrFail($id);
        $sale->delete();
        return redirect()->route('accountingSale.index')->with('success', 'Sale deleted successfully');
    }

}
