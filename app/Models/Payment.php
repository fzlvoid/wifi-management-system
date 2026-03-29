<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 
        'amount_paid', 
        'payment_date', 
        'due_date', 
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
