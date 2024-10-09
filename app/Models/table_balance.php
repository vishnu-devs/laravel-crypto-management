<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_balance extends Model
{
    use HasFactory;
    protected $table = "table_balances"; 
    protected $id = "primarykey"; 
    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'currency_id',
        'balance'
    ];
}
