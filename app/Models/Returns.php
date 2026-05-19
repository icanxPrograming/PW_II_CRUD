<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Returns extends Model
{
    use HasFactory;

    protected $table = 'returns';

    public $timestamps = false;

    protected $fillable = [
        'loan_detail_id',
        'charge',
        'amount',
    ];

    protected $casts = [
        'charge' => 'boolean',
        'amount' => 'integer',
    ];

    public function loanDetail(): BelongsTo
    {
        return $this->belongsTo(LoanDetail::class, 'loan_detail_id', 'id');
    }
}
