<?php

namespace App\Providers;
// Admin
use App\Http\View\Composers\Admin\BreadcrumbsComposer;
use App\Http\View\Composers\Admin\SidebarComposer;

// Teacher
use App\Http\View\Composers\Teacher\BreadcrumbsComposer as TeacherBreadcrumbsComposer;
use App\Http\View\Composers\Teacher\SidebarComposer as TeacherSidebarComposer;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'layouts.admin.partial.sidebar', SidebarComposer::class
        );
        View::composer(
            'layouts.admin.partial.breadcrumbs', BreadcrumbsComposer::class
        );
        View::composer(
            'layouts.teacher.partial.sidebar', TeacherSidebarComposer::class
        );
        View::composer(
            'layouts.teacher.partial.breadcrumbs', TeacherBreadcrumbsComposer::class
        );
    }
}
