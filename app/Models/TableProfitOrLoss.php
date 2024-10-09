<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableProfitOrLoss extends Model
{
    use HasFactory;

    protected $table = 'table_profit_or_loss'; // Ensure this matches your table name

    protected $fillable = [
        'sale_id',
        'purchase_id',
        'purchase_bal_id',
        'purchase_rate',
        'sale_rate',
        'qty',
        'difference',
        'profit_or_loss',
        'created_at',
        'updated_at',
    ];

}
