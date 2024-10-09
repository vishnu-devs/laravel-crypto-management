<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class table_history extends Model
{
    use HasFactory;
    

    protected $table = 'table_histories';

    protected $primaryKey = "id";

    protected $casts = [
        'purchase_balance_id' => 'array',
    ];

    // Define the relationship
    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

}
