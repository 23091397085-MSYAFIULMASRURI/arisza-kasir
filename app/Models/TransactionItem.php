<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;

        protected $fillable = ['transaction_id', 'item_name', 'price', 'quantity'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
