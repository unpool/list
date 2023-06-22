<?php

namespace App\Http\View\Composers\Teacher;

use Illuminate\View\View;

class SidebarComposer
{
    private function sidebar():array
    {
        return [
            [
                'name' => 'داشبورد',
                'is_active' =>$this->checkIsActive([
                    'teacher.dashboard'
                ]),
                'icon' => '<i class="fa fa-dashboard"></i>',
                'link' => route('teacher.dashboard'),
                'child' => []
            ],
            [
                'name' => 'پروفایل',
                'is_active' => $this->checkIsActive([
                    'teacher.profile.index'
                ]),
                'icon' => '<i class="fa fa-user"></i>',
                'link' => route('teacher.profile.index'),
                'child' => []
            ],
        ];

    }

    /**
     * @param array $routes
     * @return bool
     */
    private function checkIsActive(array $routes):bool
    {
        return in_array(\Route::currentRouteName(), $routes);
    }

    public function compose(View $view)
    {
        $view->with('sidebar', $this->sidebar());
    }
}
