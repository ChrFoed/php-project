<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Illuminate\Log\Logger;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonImmutable;

use DateTime;

class ProductsSeeder extends Seeder
{
    /**
     * To make some reliable testdata i added two near relaity examples
     *
     * @var array
     */
    protected const IDENTIFIERS = ['AMD Ryzen 5 5600X Box' => array('id' => 'B08166SLDF', 'value' => 280, 'url' => 'https://www.amazon.de/AMD-Ryzen-5-5600X-Box/dp/B08166SLDF/ref=sr_1_1?__mk_de_DE=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=FJCNW44X9S46&dchild=1&keywords=amd+ryzen+5+5600x&qid=1625128250&sprefix=AMD%2Caps%2C263&sr=8-1'), 'MSI MAG B550 Tomahawk' => array('id'=>'B08B4V583Q', 'value' => 155, 'url'=>'https://www.amazon.de/MSI-MAG-B550-Tomahawk-Motherboard/dp/B08B4V583Q/ref=sr_1_1?__mk_de_DE=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=14Y4J9X5WBK7P&dchild=1&keywords=msi+mag+b550+tomahawk&qid=1625130421&sprefix=MSI+MAG+B550%2Caps%2C225&sr=8-1' )];

    /**
     * Basic Vendor
     *
     * @var string
     */
    protected const VENDOR = 'amazon';

    /**
     * Determines the interval between the cronfetch for the testdata
     * First Item represents the "unit", the second one the value
     *
     * @var array
     */
    protected const INTERVAL = ['hours', 1];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timepoints = $this->iterateTimepoints();
        foreach (self::IDENTIFIERS as $name => $metadata) {
            foreach ($this->iterateTimepoints() as $timepoint) {
                DB::table('products')->insert([
            'identifier' => $metadata['id'],
            'price' => $metadata['value']+random_int($metadata['value']/10*-1, $metadata['value']/10*1),
            'targetprice' => $metadata['value'],
            'description' => 'Testdata for development',
            'name' => $name,
            'url' => $metadata['url'],
            'updated_at' => $timepoint->format('Y-m-d H:00:00'),
            'created_at' => $timepoint->format('Y-m-d H:00:00'),
            'vendor' => self::VENDOR
            ]);
            }
        }
    }


    /**
    * Constructs an array of timepoints to simulate cronjobs
    *
    * @return array
    */
    protected function iterateTimepoints(int $iterators=200)
    {
        //For seeding data some timepoints in the past will be generated
        $timepoints = [];
        for ($i = 0; $i <= $iterators; $i++) {
            array_push($timepoints, CarbonImmutable::now()->sub(self::INTERVAL[1]*$i, self::INTERVAL[0]));
        }
        return $timepoints;
    }
}
