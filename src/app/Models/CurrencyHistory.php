<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyHistory extends Model
{
    use HasFactory;

    protected $fillable = ['currency_id', 'amount', 'created_at', 'updated_at'];

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function getLatestData()
    {
        return $this->where('created_at', $this->max('created_at'))
            ->with('currency')
            ->get();
    }
}
