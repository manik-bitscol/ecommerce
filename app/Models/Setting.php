<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'address', 'logo', 'favicon', 'seo_title', 'seo_meta', 'seo_description', 'email', 'phone_1', 'phone_2', 'facebook', 'whatsapp', 'twitter', 'instagram', 'youtube'];
}