<?php

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\TeacherCV;

class TeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// create with CV
        factory(Teacher::class, 10)->create()
        ->each(function($teacher) {
        	/**
        	 * @var \App\Models\Teacher $teacher
        	 */
        	$teacher->cv()->save(
        		factory(TeacherCV::class)->make()
        	);
        });
    }
}
