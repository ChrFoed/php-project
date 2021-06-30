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
    protected const IDENTIFIERS = ['AMD Ryzen 5 5600X Box' => array('id' => 'B08166SLDF', 'value' => 280), 'MSI MAG B550 Tomahawk' => array('id'=>'B08B4V583Q', 'value' => 155)];

    /**
     * Basic Vendor
     *
     * @var string
     */
    protected const VENDOR = 'Amazon.de';

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
      foreach(self::IDENTIFIERS as $name => $metadata) {
        foreach($this->iterateTimepoints() as $timepoint) {
          DB::table('products')->insert([
            'identifier' => $metadata['id'],
            'price' => $metadata['value']+random_int($metadata['value']/10*-1, $metadata['value']/10*1),
            'targetprice' => $metadata['value'],
            'description' => 'Testdata for development',
            'name' => $name,
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
  protected function iterateTimepoints(int $iterators=2)
  {
    //For seeding data some timepoints in the past will be generated
    $timepoints = [];
    for ($i = 0; $i <= $iterators; $i++ ) { array_push($timepoints, CarbonImmutable::now()->sub(self::INTERVAL[1]*$i, self::INTERVAL[0]));}
    return $timepoints;
  }
}
