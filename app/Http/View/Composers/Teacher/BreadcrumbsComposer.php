<?php

namespace App\Http\View\Composers\Teacher;

use Illuminate\View\View;

class BreadcrumbsComposer
{
    private function firstSection()
    {
        return $this->standardBreadcrumbsData('خانه', route('teacher.dashboard'));
    }

    /**
     * @param string $route
     * @return array
     */
    private function RouteCorrespondToBreadcrumbs(string $route) : array
    {
        switch ($route) {
            case 'teacher.dashboard':
                $breadcrumbs = [
                    $this->standardBreadcrumbsData('داشبورد', route('teacher.dashboard')),
                ];
                break;
            case 'teacher.profile.index':
                $breadcrumbs = [
                    $this->standardBreadcrumbsData('پروفایل', route('teacher.profile.index')),
                ];
                break;
            case 'teacher.profile.edit':
                $breadcrumbs = [
                    $this->standardBreadcrumbsData('پروفایل', route('teacher.profile.index')),
                    $this->standardBreadcrumbsData('ویرایش اطلاعات پروفایل'),
                ];
                break;
            default:
                $breadcrumbs = [];
                break;
        }
        return array_merge([$this->firstSection()], $breadcrumbs);
    }

    public function compose(View $view)
    {
        $view->with('breadcrumbs', $this->RouteCorrespondToBreadcrumbs(\Route::currentRouteName()));
    }


    /**
     * @param $name
     * @param null $link
     * @return array
     */
    private function standardBreadcrumbsData($name, $link = null):array
    {
        return [
            'name' => $name,
            'link' => $link
        ];
    }
}
