<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'offering_type',
        'name',
        'business_name',
        'business_address',
        'category',
        'description',
        'status',
        'upload_fee',
        'payment_status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'upload_fee' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function testers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'product_user',
            'product_id',
            'user_id'
        )->withTimestamps();
    }

    public function feedback(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    public function analyses(): HasMany
    {
        return $this->hasMany(ProductAnalysis::class);
    }
}
