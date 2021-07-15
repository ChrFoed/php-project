<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request as DefaultRequest;

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
    public function __construct(Products $products, Client $client)
    {
        $this->products = $products;
        $this->client = $client;
        $this->client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
        $this->client->setServerParameter('HTTP_ACCEPT_LANGUAGE', 'de-DE');
    }

    /**
     * scrape based on vendor
     *
     * @param  Request  $request
     * @param  Vendor  $vendor
     *
    * @return HttpResponse
     */
    public function scrapPriceByVendor(Request $request=null, string $vendor='amazon')
    {
        $products = $this->products::getProductsByVendor('amazon')->get();
        foreach ($products as $product) {
            $updateProduct = $product->toArray();
            $price = $this->getPriceFromPage($updateProduct['url'], $updateProduct['vendor']);
            unset($updateProduct['created_at']);
            $updateProduct['updated_at'] = CarbonImmutable::now()->format('Y-m-d H:m:s');
            $updateProduct['price'] = intval(isset($price[0]) ? $price[0] : floatval(99999));
            $this->products::updateOrCreate($updateProduct);
        }
        return response(sprintf('Vendorgroup %s fetched', $vendor), 200)->header('Content-Type', 'text/plain');
    }

    /**
     * scrape price based on identifier
     *
     * @param  [type] $request    [description]
     * @param  string $identifier [description]
     * @return [type]             [description]
     */
    public function scrapPriceByIdentifier(Request $request=null, string $vendor, string $identifier)
    {
        $products = $this->products::getProductsByVendor($vendor)->where('identifier', $identifier)->get();
        foreach ($products as $product) {
            $updateProduct = $product->toArray();
            $price = $this->getPriceFromPage($updateProduct['url'], $updateProduct['vendor']);
            unset($updateProduct['created_at']);
            $updateProduct['updated_at'] = CarbonImmutable::now()->format('Y-m-d H:m:s');
            $updateProduct['price'] = intval(isset($price[0]) ? $price[0] : floatval(99999));
            $this->products::updateOrCreate($updateProduct);
        }
        return response(sprintf('Product with identifier %s fetched', $identifier), 200)->header('Content-Type', 'text/plain');
    }

    /**
     * get Price from differnet Page
     * @param  string $url    url to ressource
     * @param  string $vendor id from vendor
     * @return int    current Price of Item
     */
    protected function getPriceFromPage(string $url, string $vendor)
    {
        $price = 99999;
        $crawler = $this->client->request('GET', $url);
        if ($vendor == 'amazon') {
            $price = $crawler->filter('#priceblock_ourprice')->each(function ($node) {
                return floatval($node->text());
            });
            if (!isset($price[0])) {
                $price = $crawler->filter('#priceblock_pospromoprice')->each(function ($node) {
                    return floatval($node->text());
                });
            }
            if (!isset($price[0])) {
                $price = $crawler->filter('#priceblock_dealprice')->each(function ($node) {
                    return floatval($node->text());
                });
            }
        }
        return $price;
    }
}
