<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $records = [
            ["name" => "Alabama"],
            ["name" => "Alaska"],
            ["name" => "Arizona"],
            ["name" => "Arkansas"],
            ["name" => "California"],
            ["name" => "Colorado"],
            ["name" => "Connecticut"],
            ["name" => "Delaware"],
            ["name" => "Florida"],
            ["name" => "Georgia"],
            ["name" => "Hawaii"],
            ["name" => "Idaho"],
            ["name" => "Illinois"],
            ["name" => "Indiana"],
            ["name" => "Iowa"],
            ["name" => "Kansas"],
            ["name" => "Kentucky"],
            ["name" => "Louisiana"],
            ["name" => "Maine"],
            ["name" => "Maryland"],
            ["name" => "Massachusetts"],
            ["name" => "Michigan"],
            ["name" => "Minnesota"],
            ["name" => "Mississippi"],
            ["name" => "Missouri"],
            ["name" => "Montana"],
            ["name" => "Nevada"],
            ["name" => "New-hampshire"],
            ["name" => "New-jersey"],
            ["name" => "New-mexico"],
            ["name" => "New-york"],
            ["name" => "North-carolina"],
            ["name" => "North-dakota"],
            ["name" => "Ohio"],
            ["name" => "Oklahoma"],
            ["name" => "Oregon"],
            ["name" => "Rhode-island"],
            ["name" => "South-carolina"],
            ["name" => "South-dakota"],
            ["name" => "Tennessee"],
            ["name" => "Texas"],
            ["name" => "utah"],
            ["name" => "Vermont"],
            ["name" => "Virginia"],
            ["name" => "Washington"],
            ["name" => "West-virginia"],
            ["name" => "Wisconsin"],
            ["name" => "Wyoming"],
        ];
        foreach($records as $record){
            State::create($record);
        }
    }
}
