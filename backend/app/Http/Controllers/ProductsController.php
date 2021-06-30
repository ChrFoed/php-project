<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ProductsResource;
use App\Models\Products;

class ProductsController extends Controller
{

   /**
   * Stores a new Product Item into Database
   *
   * @param  \Illuminate\Http\Request  $request
   * @return HttpResponse
   */
    public function addProduct(Request $request)
    {
        var_dump($request->all());
        return response('Product added to Database', 200)
                  ->header('Content-Type', 'text/plain');
    }

    /**
    * Removes a Product Item from Database
    *
    * @param  \Illuminate\Http\Request  $request
    * @return HttpResponse
    */
    public function deleteProduct(Request $request)
    {
        return response('Product removed Database', 200)
                   ->header('Content-Type', 'text/plain');
    }
}
