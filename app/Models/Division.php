<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
    public function states(): HasMany
    {
        return $this->hasMany(State::class);
    }
}