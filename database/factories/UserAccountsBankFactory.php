<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\AccountBank;
use Faker\Generator as Faker;

$factory->define(AccountBank::class, function (Faker $faker) {
	return [
		'first_name' => $faker->name,
		'last_name' => $faker->lastName,
		'account_number' => $faker->bankAccountNumber,
	];
});
