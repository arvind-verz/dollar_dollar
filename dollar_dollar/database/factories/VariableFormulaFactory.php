<?php

use Faker\Generator as Faker;

$factory->define(App\FormulaVariable::class, function (Faker $faker) {
    return [
        'product_id' => 1 ,
        'placement_range_id' => 1,
        'tenure_type' => 2,
        'tenure' =>  3,
        'bonus_interest ' =>4 ,
    ];
});
