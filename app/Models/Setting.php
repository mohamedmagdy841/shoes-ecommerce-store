<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'email',
        'logo',
        'phone',
        'favicon',
        'street',
        'city',
        'country',
        'facebook',
        'x',
        'instagram',
        'youtube',
    ];
}
