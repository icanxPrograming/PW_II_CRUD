<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanDetail extends Model
{
    use HasFactory;

    protected $table = 'loan_detail';

    protected $fillable = [
        'loan_id',
        'book_id',
        'is_return',
    ];

    protected $casts = [
        'is_return' => 'boolean',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loans::class, 'loan_id', 'id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
