<?php

use Illuminate\Database\Seeder;
use App\Models\Month;
class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Month::create(["name"=> 'January', 'month_number' => '1']);
        Month::create(["name"=> 'February', 'month_number' => '2']);
        Month::create(["name"=> 'March', 'month_number' => '3']);
        Month::create(["name"=> 'April', 'month_number' => '4']);
        Month::create(["name"=> 'May', 'month_number' => '5']);
        Month::create(["name"=> 'June', 'month_number' => '6']);
        Month::create(["name"=> 'July', 'month_number' => '7']);
        Month::create(["name"=> 'August', 'month_number' => '8']);
        Month::create(["name"=> 'September', 'month_number' => '9']);
        Month::create(["name"=> 'October', 'month_number' => '10']);
        Month::create(["name"=> 'November', 'month_number' => '11']);
        Month::create(["name"=> 'December', 'month_number' => '12']);
    }
}
