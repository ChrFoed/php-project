<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#use DataJoe\Extensions\Illuminate\Database\DatabaseServiceProvider as DataJoe;

class Products extends Model
{
    use HasFactory;

    protected $hidden = [
        'id'
    ];

    protected $fillable = ['identifier','name','description','vendor','url', 'price', 'targetprice'];


    #protected $dateFormat = 'Y-M-D HH:mm:00';

    /**
     * get Last Product states
     * Enhancement: subselect special item
     * @return Builder  Illuminate\Database\Eloquent\Builder
     */
    protected function getLastProductsState()
    {
        return $this
        ->distinct('identifier')
        ->orderByDesc('identifier', 'updated_at');
    }

    /**
     * Returns all Products added to an vendor
     * @param  string $vendor [description]
     * @return Builder  Illuminate\Database\Eloquent\Builder
     */
    protected function getProductsByVendor(string $vendor)
    {
        return $this
        ->distinct('identifier')
        ->where('vendor', $vendor);
    }

    /**
     * get Latest Products By Vendor
     * @param  string $vendor identifier for vendor
     * @return Builder  Illuminate\Database\Eloquent\Builder
     */
    protected function getLastProductsByVendor(string $vendor)
    {
        /*
        Create Subquery for last update because eloquent has a different implementation of distinct on
        https://github.com/laravel/framework/issues/10863
         */
        $latestUpdates = $this
                           ->select('identifier', $this::raw('MAX(updated_at) as last_update'))
                           ->where('vendor', $vendor)
                           ->groupBy('identifier');

        return $this->joinSub($latestUpdates, 'latest_updates', function ($join) {
            $join->on('products.identifier', '=', 'latest_updates.identifier')->on('products.updated_at', '=', 'latest_updates.last_update');
        });
    }
}
