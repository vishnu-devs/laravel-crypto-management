<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class accountingPurchasebalance extends Model
{
    use HasFactory;
    protected $table = "accounting_purchasebalances"; 
    protected $id = "primarykey"; 
    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'purchase_id',
        'purchaseBalance',
        'status'
    ];
}
