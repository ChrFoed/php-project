<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ProductsResource;
use App\Models\Products;

class ProductsController extends Controller
{

    /**
   * The Products Model.
   *
   * @var Products
   */
    protected $products;

    /**
     * Create a new controller instance.
     *
     * @param  Products  $products
     * @return void
     */
    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
    * Stores a new Product Item into Database
    *
    * @param  \Illuminate\Http\Request  $request
    * @return HttpResponse
    */
    public function addProduct(Request $request)
    {
        $product = $request->all();
        $product['price'] = 99999;
        $this->products->create($product);
        return response()->json(['message' => sprintf('Product with name "%s" added to database', $product['name'])], 200)->header('Content-Type', 'application/json');
    }

    /**
    * Updates a Product Item into Database
    *
    * @param  \Illuminate\Http\Request  $request
    * @return HttpResponse
    */
    public function updateProduct(Request $request)
    {
        $product = $request->all();
        $this->products->whereIn('identifier', [$product['identifier']])->update($product);
        return response()->json(['message' => sprintf('Product with name "%s" updated', $product['name'])], 200)->header('Content-Type', 'application/json');
    }

    /**
    * Removes a Product Item from Database
    *
    * @param  \Illuminate\Http\Request  $request
    * @return HttpResponse
    */
    public function deleteProduct(Request $request, $identifier)
    {
        $this->products->where('identifier', $identifier)->delete();
        return response()->json(['message' => sprintf('Product with identifier "%s" deleted', $identifier)], 200)->header('Content-Type', 'application/json');
    }
}
