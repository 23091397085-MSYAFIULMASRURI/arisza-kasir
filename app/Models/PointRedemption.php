<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointRedemption extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'points_used', 'description'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
