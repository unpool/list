<?php

use App\Repositories\SliderRepository;
use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{

    private $slider_repo;

    public function __construct(SliderRepository $slider)
    {
        $this->slider_repo = $slider;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->slider_repo->create([
            'node_id' => 1,
            'title' => 'بسته آموزش زبان انگلیسی',
            'description' => 'خرید پستی بسته آموزش زبان انگلیسی استاد عطایی بهترین پکیج آموزش زبان انگلیسی جامع ترین و بهترین راه یادگیری زبان انگلیسی در منزل و سریع.',
        ]);

        $this->slider_repo->create([
            'node_id' => 2,
            'title' => 'بسته آموزش زبان انگلیسی خردسال',
            'description' => 'این بسته زبان آموز را برای برقراری ارتباط موفق و توام با اعتماد به نفس با جهان خارج، اعم از انگلیسی‌زبان‌ها و غیر انگلیسی زبان‌هایی که به زبان انگلیسی صحبت',
        ]);

        $this->slider_repo->create([
            'node_id' => 3,
            'title' => 'بسته آموزش زبان انگلیسی آموزش بین ۵ تا ۷',
            'description' => 'بسته های خودآموز زبان انگلیسی SG5، زبان انگلیسی خود را سریعتر و عمیق تر از آنچه تصور می کنید از سطح مبتدی به سطح پیشرفته برسانید.',
        ]);
    }
}
