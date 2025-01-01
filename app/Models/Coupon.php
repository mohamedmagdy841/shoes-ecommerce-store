<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'used_count',
        'limit',
        'type',
        'value',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function getIsValidAttribute()
    {
        $isWithinDateRange = Carbon::now()->between($this->start_date, $this->end_date, true);
        $hasUsageLeft = is_null($this->limit) || $this->limit > 0;
        return $isWithinDateRange && $hasUsageLeft;
    }
}
