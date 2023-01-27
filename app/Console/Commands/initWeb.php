<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;

class initWeb extends Command
{

    private $dataCities = [

        ['name' => 'New York', 'lat' => '25.761681', 'long' => '-80.191788'],
        ['name' => 'Orlando Florida', 'lat' => '28.538336', 'long' => '-81.379234'],
        ['name' => 'Miami', 'lat' => '43.000000', 'long' => '-75.000000']

    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:initWeb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'load data required from platform';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach ($this->dataCities as $key => $value) {
            $city = new City();
            $city->name =$value['name'];
            $city->lat =$value['lat'];
            $city->long =$value['long'];
            $city->save();
        }
        return 'success data';
    }
}
