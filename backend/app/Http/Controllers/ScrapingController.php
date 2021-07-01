<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;

class ScrapingController extends Controller
{

  /**
   * To make some reliable testdata i added two near relaity examples
   *
   * @var array
   */
    protected const BASEURLS = ['amazon' => array('uri' => 'https://www.amazon.de/AMD-Ryzen-5-5600X-Box/dp/B08166SLDF/ref=sr_1_1?__mk_de_DE=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=FJCNW44X9S46&dchild=1&keywords=amd+ryzen+5+5600x&qid=1625128250&sprefix=AMD%2Caps%2C263&sr=8-1')];
    /**
    * Stores a new Product Item into Database
    */
    public function scrapPrice(Request $request=null, string $vendor='amazon')
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://duckduckgo.com/html/?q=Laravel');
        var_dump('test');
    }
}
