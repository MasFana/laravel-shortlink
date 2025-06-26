<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'url',
        'click_count'
    ];
}