<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $hidden = [
        'id'
    ];

    protected $dateFormat = 'Y-M-D HH:mm:00';
}
