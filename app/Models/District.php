<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'division_id',
    ];

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}