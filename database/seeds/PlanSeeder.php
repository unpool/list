<?php

use App\Repositories\PlanRepository;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{

    /**
     * @var
     */
    private $plan_repo;

    public function __construct(PlanRepository $plan)
    {
        $this->plan_repo = $plan;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->plan_repo->create([
            'name' => 'ماهانه',
            'score' => '125',
            'period' => '30',
            'price' => '250000',
            'share_invited' => '10000',
            'is_special' => 0,
        ]);

        $this->plan_repo->create([
            'name' => 'سالیانه',
            'score' => '12556',
            'period' => 365,
            'price' => 2050000,
            'share_invited' => '60000',
            'is_special' => 1,
        ]);
    }
}
