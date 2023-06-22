<?php

namespace App\Http\View\Composers\Admin;

use Illuminate\View\View;

class BreadcrumbsComposer
{
	private function firstSection()
	{
		return $this->standardBreadcrumbsData('خانه', route('admin.dashboard'));
	}

	/**
	 * @param string $route
	 * @return array
	 */
	private function RouteCorrespondToBreadcrumbs(string $route): array
	{
		switch ($route) {
			case 'admin.dashboard':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('داشبورد'),
				];
				break;

				// USER
			case 'admin.user.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('کاربران'),
				];
				break;
			case 'admin.user.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('کاربران', route('admin.user.index')),
					$this->standardBreadcrumbsData('ثبت کاربر'),
				];
				break;
			case 'admin.user.show':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('کاربران', route('admin.user.index')),
					$this->standardBreadcrumbsData('نمایش اطلاعات کاربر'),
				];
				break;
			case 'admin.user.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('کاربران', route('admin.user.index')),
					$this->standardBreadcrumbsData('ویرایش اطلاعات کاربر'),
				];
				break;
			case 'admin.user.usersInviteOtherUsersByCountAndDate':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('کاربران', route('admin.user.index')),
					$this->standardBreadcrumbsData('افرادی که تعداد خاصی از افراد را در بازه‌ی زمانی خاص معرفی کرده‌اند.'),
				];
				break;
			case 'admin.user.usersInviteUsersWithActiveProfile':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('کاربران', route('admin.user.index')),
					$this->standardBreadcrumbsData('افرادی که افرادی با پروفایل فعال را معرفی کرده‌اند.'),
				];
				break;

				// NODE
			case 'admin.node.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('دسته‌ بندی'),
					$this->standardBreadcrumbsData('نمایش پکیج ‌ها'),
				];
			case 'admin.node.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('دسته‌ بندی'),
					$this->standardBreadcrumbsData('ویرایش'),
				];
				break;
			case 'admin.node.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('دسته‌ بندی'),
					$this->standardBreadcrumbsData('ایجاد'),
				];
				break;
			case 'admin.node.best.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست دسته‌ها', route('admin.node.index')),
					$this->standardBreadcrumbsData('بهترین دسته‌ها'),
				];
				break;

				// PRODUCT
			case 'admin.product.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست محصولات'),
				];
				break;
			case 'admin.product.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست محصولات', route('admin.product.index')),
					$this->standardBreadcrumbsData('ثبت محصول'),
				];
				break;
			case 'admin.product.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست محصولات', route('admin.product.index')),
					$this->standardBreadcrumbsData('ویرایش محصول'),
				];
				break;

				// SLIDER
			case 'admin.slider.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('اسلایدر‌ها'),
					$this->standardBreadcrumbsData('نمایش لیست اسلایدر‌ها'),
				];
				break;
			case 'admin.slider.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('اسلایدر‌ها', route('admin.slider.index')),
					$this->standardBreadcrumbsData('ایجاد'),
				];
				break;
			case 'admin.slider.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('اسلایدر‌ها', route('admin.slider.index')),
					$this->standardBreadcrumbsData('ویرایش'),
				];
				break;

				// TEACHER
			case 'admin.teachers.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
				];
				break;
			case 'admin.teachers.show':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('نمایش اطلاعات مربی'),
				];
				break;
			case 'admin.teachers.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('ثبت مربی'),
				];
				break;
			case 'admin.teachers.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('ویرایش مربی'),
				];
				break;
			case 'admin.teachers.cv.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('ثبت رزومه مربی'),
				];
				break;
			case 'admin.teachers.group.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('لیست گروه‌ها', route('admin.teachers.group.index')),
				];
				break;
			case 'admin.teachers.group.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('گروه‌ها', route('admin.teachers.group.index')),
					$this->standardBreadcrumbsData('ثبت گروه')
				];
				break;
			case 'admin.teachers.group.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست مربیان', route('admin.teachers.index')),
					$this->standardBreadcrumbsData('گروه‌ها', route('admin.teachers.group.index')),
					$this->standardBreadcrumbsData('ویرایش گروه')
				];
				break;
				// PACKAGES
			case 'admin.package.index':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست پکیج‌ها', route('admin.package.index')),
				];
				break;
			case 'admin.package.create':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست پکیج‌ها', route('admin.package.index')),
					$this->standardBreadcrumbsData('ایجاد پکیج'),
				];
				break;
			case 'admin.package.edit':
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست پکیج‌ها', route('admin.package.index')),
					$this->standardBreadcrumbsData('ویرایش پکیج'),
				];
				break;
				//plan
			case "admin.plan.index":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست اشتراک ها', route('admin.plan.index')),
				];
				break;
			case "admin.plan.create":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست اشتراک ها', route('admin.plan.index')),
					$this->standardBreadcrumbsData('ثبت اشتراک'),
				];
				break;
			case "admin.plan.edit":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('لیست اشتراک ها', route('admin.plan.index')),
					$this->standardBreadcrumbsData('ویرایش اشتراک'),
				];
				break;
			case "admin.report.user.index":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('گزارش کلی کاربران'),
				];
				break;
			case "admin.report.user.register":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('ثبت نام کاربران'),
				];
				break;
			case "admin.report.user.completeProfile":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('پروفایل فعال'),
				];
				break;
			case "admin.report.user.birthday":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('تاریخ تولد کاربران'),
				];
				break;
			case "admin.report.user.doestNotHaveOrder":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('کاربران بدون خرید'),
				];
				break;
			case "admin.report.user.haveOrder":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('کاربران دارای خرید'),
				];
				break;
			case "admin.report.user.haveIncome":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('کاربران با کسب درآمد'),
				];
				break;
			case "admin.report.user.orderList":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('گزارشات'),
					$this->standardBreadcrumbsData('لیست سفارشات کاربر'),
				];
				break;

			case "admin.setting.create":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('تنظیمات'),
					$this->standardBreadcrumbsData('راهنما'),
				];
				break;
			case "admin.discounts.index":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('تخفیف‌ها'),
					$this->standardBreadcrumbsData('لیست'),
				];
				break;
			case "admin.discounts.create":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('تخفیف‌ها'),
					$this->standardBreadcrumbsData('ایجاد'),
				];
				break;
			case "admin.discounts.edit":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('تخفیف‌ها'),
					$this->standardBreadcrumbsData('ویرایش'),
				];
				break;
			case "admin.discounts.edit.completion":
				$breadcrumbs = [
					$this->standardBreadcrumbsData('تخفیف‌ها'),
					$this->standardBreadcrumbsData('ویرایش و ثبت جزییات'),
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
	private function standardBreadcrumbsData($name, $link = null): array
	{
		return [
			'name' => $name,
			'link' => $link,
		];
	}
}
