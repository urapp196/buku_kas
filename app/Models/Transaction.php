<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'type',
        'date',
        'category',
        'description',
        'amount',
    ];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'float',
    ];

    /**
     * Format amount as Indonesian Rupiah.
     */
    public function formattedAmount(): string
    {
        return 'Rp' . number_format($this->amount, 0, ',', '.');
    }
}
