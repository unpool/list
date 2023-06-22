<?php

use App\Models\AccountBank;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		// TODO : add user_imies relation to seeder
		factory(\App\User::class, 10)->create()
			->each(function ($user) {
				/* @var User $user */
				$user->accountsBanks()->save(
					factory(AccountBank::class)->make()
				);
			});
	}
}
