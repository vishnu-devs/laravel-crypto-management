<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Http\Controllers\Backend\Accounting\SaleController;
use App\Http\Controllers\Backend\Accounting\PurchaseController;

class CsvImportController extends Controller
{
    private $saleController;
    private $purchaseController;

    public function __construct()
    {
        $this->saleController = app()->make(SaleController::class);
        $this->purchaseController = app()->make(PurchaseController::class);
    }

    public function index() {
        return view('backend.pages.accounting.import');
    }

    public function importCsv(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'nullable|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $this->importCsvFile($csvFile);
        }

        return redirect()->back()->with('success', 'CSV file imported successfully.');
    }

    private function importCsvFile($file)
    {
        $handle = fopen($file->getRealPath(), 'r');
        fgetcsv($handle); // Skip header row

        while (($data = fgetcsv($handle)) !== FALSE) {
            $currencyName = $data[0]; // Currency
            $rate = $this->parseDecimal($data[1]); // Rate
            $qty = $this->parseDecimal($data[2]); // Qty
            $type = $data[3]; // Type ('dr' or 'cr')
            $dateTime = $this->formatDateTime($data[4]); // Date-time

            $currency = DB::table('currency')->where('currency', $currencyName)->first();

            if ($currency) {
                $currencyId = $currency->id;
                $request = Request::create(
                    $type === 'dr' ? route('accountingSale.store') : route('accountingPurchase.store'),
                    'POST',
                    [
                        'currency_id' => $currencyId,
                        'qty' => $qty,
                        'rate' => $rate,
                        'timing' => $dateTime,
                    ]
                );

                if ($type === 'dr') {
                    $this->saleController->store($request);
                } elseif ($type === 'cr') {
                    $this->purchaseController->store($request);
                }
            }
        }

        fclose($handle);
    }

    private function parseDecimal($value)
    {
        return is_numeric($value) ? (float) $value : 0.0;
    }

    private function formatDateTime($value)
    {
        return Carbon::createFromFormat('d-m-Y H:i', $value)->format('Y-m-d H:i:s');
    }
}
