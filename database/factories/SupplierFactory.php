<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Supplier::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'email' => $faker->companyEmail,
        'phone' => $faker->tollFreePhoneNumber,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'region' => $faker->state,
        'country' => 'BD',
        'postal_code' => $faker->postcode,
    ];
});
