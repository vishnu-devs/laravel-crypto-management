<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountingSale extends Model
{
    use HasFactory;

    protected $table = "accounting_sales"; 
    protected $id = "primarykey"; 
    public $timestamps = true; // Enable timestamps

    protected $fillable = [
        'currency_id',
        'rate',
        'qty',
        'timing'
    ];
    // Define the relationship with the Currency model
    public function currency()
    {
        return $this->belongsTo(currency::class);
    }
}
