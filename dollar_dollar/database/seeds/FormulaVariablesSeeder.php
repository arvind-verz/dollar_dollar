<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\FormulaVariable;

class FormulaVariablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = Faker\Factory::create();

        for($i = 0; $i < 1; $i++) {
            FormulaVariable::create([
                'product_id' => 1 ,
                'placement_range_id' => 1,
                'tenure_type' => 2,
                'tenure' =>1,
                'bonus_interest ' => 1.5 ,
            ]);
        }
    }
}
