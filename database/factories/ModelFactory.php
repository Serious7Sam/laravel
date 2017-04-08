<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Entity\Discount::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'value' => $faker->randomFloat(4, 0.01, 0.99),
    ];
});

$factory->define(\App\Entity\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->name,
        'price' => $faker->randomFloat(4, 0, 10000),
        'is_active' => $faker->boolean(70),
    ];
});

$factory->define(\App\Entity\Voucher::class, function (Faker\Generator $faker) {
    return [
        'discount_id' => function() {
            return factory(\App\Entity\Discount::class)->create()->id;
        },
        'start_date' => $faker->dateTimeBetween('-2 days', '+2 days'),
        'end_date' => $faker->dateTimeBetween('-1 days', '+5 days'),
        'is_active' => $faker->boolean(70),
    ];
});
