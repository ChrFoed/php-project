<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\CarbonImmutable;

class ScrapingController extends Controller
{

  /**
   * Define vendors for testing purposes
   *
   * @var array
   */
    protected const BASEURLS = ['amazon' => array('uri' => '')];

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
     * scrape based on vendor
     *
     * @param  Request  $request
     * @param  Vendor  $vendor
     *
     * @return void
     */
    public function scrapPrice(Request $request=null, string $vendor='amazon')
    {
        $client = new Client();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
        $client->setServerParameter('HTTP_ACCEPT_LANGUAGE', 'de-DE');
        $products = $this->products::getProductsByVendor('amazon')->get();
        foreach ($products as $product) {
            $updateProduct = $product->toArray();
            $crawler = $client->request('GET', $product['url']);
            $price = $crawler->filter('#priceblock_ourprice')->each(function ($node) {
                return floatval($node->text());
            });
            unset($updateProduct['created_at']);
            $updateProduct['updated_at'] = CarbonImmutable::now()->format('Y-m-d H:m:s');
            $updateProduct['price'] = intval(isset($price[0]) ? $price[0] : floatval(99999));
            $this->products::updateOrCreate($updateProduct);
        }
    }
}
