<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dark_mode_set',
        'items_per_page',
        'flat_nav_bar_set',
        'fixed_header_set',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
