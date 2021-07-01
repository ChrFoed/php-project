<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
        'url'
    ];

    protected $dateFormat = 'Y-M-D HH:mm:00';

    protected function getLastProductsState()
    {
        return $this
        ->distinct('identifier')
        ->orderByDesc('identifier', 'updated_at');
    }
}
