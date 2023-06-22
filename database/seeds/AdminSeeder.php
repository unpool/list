<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    private $adminRepo;

    public function __construct(\App\Repositories\AdminRepository $adminRepository)
    {
        $this->adminRepo = $adminRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->adminRepo->create([
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('000000')
        ]);
    }
}
