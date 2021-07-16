<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\CarbonImmutable;
use Symfony\Component\HttpClient\HttpClient;

#use Illuminate\Http\Request as DefaultRequest;

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
     * Some Proxy Servers
     * https://www.netzwelt.de/proxy/index.html
     * @var Array
     */
    protected $proxies = [ '85.28.193.95:8080', '85.214.250.48:3128', '85.214.81.21:8080'];


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


    protected function getCrawlerClient()
    {
        #$proxy = $this->proxies[mt_rand(0, count($this->proxies)-1)];
        #$client = new Client(HttpClient::create(['proxy' => $proxy, 'timeout' => 60]));
        $client = new Client(HttpClient::create(['timeout' => 60]));
        $client->followRedirects();
        $client->setServerParameter('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36');
        $client->setServerParameter('HTTP_ACCEPT_LANGUAGE', 'de-DE');
        $client->setServerParameter('HTTP_REFERER', 'https://www.google.com/');
        return $client;
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
        return response()->json(['message' => sprintf('Vendorgroup %s fetched', $vendor)], 200)->header('Content-Type', 'application/json');
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
        return response()->json(['message' => sprintf('Product with identifier %s fetched', $identifier)], 200)->header('Content-Type', 'application/json');
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
        $client = $this->getCrawlerClient();
        $crawler = $client->request('GET', $url.$this->generateQueryParam());

        sleep(1);
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

    /**
     * generate 'randopm' query params
     * @return string unix_timestamp query
     */
    protected function generateQueryParam()
    {
        return sprintf("?time=%s", strval(strtotime("now")));
    }
}
