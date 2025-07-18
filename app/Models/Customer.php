<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'points'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function redemptions()
    {
        return $this->hasMany(PointRedemption::class);
    }
}
