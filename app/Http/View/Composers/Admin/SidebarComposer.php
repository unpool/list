<?php

namespace App\Http\View\Composers\Admin;

use App\Enums\SettingType;
use Illuminate\View\View;

class SidebarComposer
{
	private function sidebar(): array
	{
		return [
			[
				'name' => 'داشبورد',
				'is_active' => $this->checkIsActive(['admin.dashboard']),
				'icon' => '<i class="fa fa-dashboard"></i>',
				'link' => route('admin.dashboard'),
				'child' => [],
			],
			[
				'name' => 'کاربران',
				'is_active' => $this->checkIsActive(['admin.user.index', 'admin.user.show', 'admin.user.edit', 'admin.user.create']),
				'icon' => '<i class="fa fa-users"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive(['admin.user.index']),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.user.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive(['admin.user.create']),
						'icon' => '<i class="fa fa-plus"></i>',
						'link' => route('admin.user.create'),
					],
				],
			],
			[
				'name' => 'دسته‌ها',
				'is_active' => $this->checkIsActive([
					'admin.node.index',
					'admin.node.edit',
					'admin.node.create',
					'admin.node.options',
					'admin.node.best.index',
				]),
				'icon' => '<i class="fa fa-cube"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.node.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.node.index'),

					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive([
							'admin.node.create',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.node.create'),
					],
					[
						'name' => 'بهترین‌ها',
						'is_active' => $this->checkIsActive([
							'admin.node.best.index',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.node.best.index'),
					],
				],
			],
			[
				'name' => 'پکیج‌ها',
				'is_active' => $this->checkIsActive([
					'admin.package.index',
					'admin.package.create',
					'admin.package.edit',
				]),
				'icon' => '<i class="fa fa-cubes"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.package.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.package.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive([
							'admin.package.create',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.package.create'),
					]
				],


            ],

            [
				'name' => 'رادیو',
				'is_active' => $this->checkIsActive([
					'admin.radio.index',
					'admin.radio.create',
					'admin.radio.edit',
				]),
				'icon' => '<i class="fa fa-cubes"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.radio.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.radio.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive([
							'admin.radio.create',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.radio.create'),
					]
				],
            ],

            [
				'name' => 'نظرات کاربران',
				'is_active' => $this->checkIsActive([
					'admin.user_comment.index',
					'admin.user_comment.create',
					'admin.user_comment.edit',
				]),
				'icon' => '<i class="fa fa-cubes"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.user_comment.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.user_comment.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive([
							'admin.user_comment.create',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.user_comment.create'),
					]
				],
			],
			[
				'name' => 'محصولات',
				'is_active' => $this->checkIsActive([
					'admin.product.index',
					'admin.product.create',
					'admin.product.edit',
				]),
				'icon' => '<i class="fa fa-cubes"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.product.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.product.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive([
							'admin.product.create',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.product.create'),
					],
				],
			],
			[
				'name' => 'اساتید',
				'is_active' => $this->checkIsActive([
					'admin.teachers.index',
					'admin.teachers.create',
					'admin.teachers.edit',
					'admin.teachers.cv.edit',
					'admin.teachers.group.index',
					'admin.teachers.group.create',
					'admin.teachers.group.edit',
				]),
				'icon' => '<i class="fa fa-graduation-cap"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.teachers.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.teachers.index'),
					],
					[
						'name' => 'گروه‌ها',
						'is_active' => $this->checkIsActive([
							'admin.teachers.group.index',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.teachers.group.index'),
					]
				],
			],
			[
				'name' => 'تیکت ها',
				'is_active' => $this->checkIsActive([
					'admin.tickets.without.answer',
					'admin.tickets.answered',
				]),
				'icon' => '<i class="fa fa-ticket"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'تیکت های بدون پاسخ',
						'is_active' => $this->checkIsActive([
							'admin.tickets.without.answer',
						]),
						'icon' => '<i class="fa fa-close"></i>',
						'link' => route('admin.tickets.without.answer'),
					],
					[
						'name' => 'تیکت های پاسخ داده شده',
						'is_active' => $this->checkIsActive([
							'admin.tickets.answered',
						]),
						'icon' => '<i class="fa fa-check"></i>',
						'link' => route('admin.tickets.answered'),
					]
				],
			],
			[
				'name' => 'صورت حساب ها',
				'is_active' => $this->checkIsActive(['admin.order.index', 'admin.order.create', 'admin.order.edit']),
				'icon' => '<i class="fa fa-dollar"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.order.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.order.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive(['admin.order.create']),
						'icon' => '<i class="fa fa-plus"></i>',
						'link' => route('admin.order.create'),
					],
				]
			],
			[
				'name' => 'اشتراک',
				'is_active' => $this->checkIsActive(['admin.plan.index', 'admin.plan.create', 'admin.plan.edit']),
				'icon' => '<i class="fa fa-flag"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.plan.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.plan.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive(['admin.plan.create']),
						'icon' => '<i class="fa fa-plus"></i>',
						'link' => route('admin.plan.create'),
					],
				]
			],
			[
				'name' => 'اسلایدر‌ها',
				'is_active' => $this->checkIsActive(['admin.slider.index', 'admin.slider.create', 'admin.slider.edit']),
				'icon' => '<i class="fa fa-image"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.slider.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.slider.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive(['admin.slider.create']),
						'icon' => '<i class="fa fa-plus"></i>',
						'link' => route('admin.slider.create'),
					]
				],
			],
			[
				'name' => 'پرداخت',
				'is_active' => $this->checkIsActive(['admin.deposit.index']),
				'icon' => '<i class="fa fa-money"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'درخواست های برداشت',
						'is_active' => $this->checkIsActive([
							'admin.deposit.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.deposit.index'),
					],
				],
			],
			[
				'name' => 'تنظیمات',
				'is_active' => $this->checkIsActive(['admin.setting.create']),
				'icon' => '<i class="fa fa-cog"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'راهنما',
						'is_active' => $this->checkIsActive([
							'admin.setting.create',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.setting.create', ['key' => SettingType::HELPER]),
					],
				]
			],
			[
				'name' => 'تخفیفات',
				'is_active' => $this->checkIsActive([
					'admin.discounts.index',
					'admin.discounts.create',
					'admin.discounts.edit',
					'admin.discounts.edit.completion'
				]),
				'icon' => '<i class="fa fa-percent"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'لیست',
						'is_active' => $this->checkIsActive([
							'admin.discounts.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.discounts.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive(['admin.discounts.create']),
						'icon' => '<i class="fa fa-plus"></i>',
						'link' => route('admin.discounts.create'),
					]
				]
			],
			[
				'name' => 'گردونه شانس',
				'is_active' => $this->checkIsActive([
					'admin.chance.wheel.index',
					'admin.chance.wheel.create',
					'admin.chance.wheel.edit',
				]),
				'icon' => '<i class="fa fa-circle-o-notch"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'گردونه ها',
						'is_active' => $this->checkIsActive([
							'admin.chance.wheel.index',
						]),
						'icon' => '<i class="fa fa-list"></i>',
						'link' => route('admin.chance.wheel.index'),
					],
					[
						'name' => 'ایجاد',
						'is_active' => $this->checkIsActive(['admin.chance.wheel.create']),
						'icon' => '<i class="fa fa-plus"></i>',
						'link' => route('admin.chance.wheel.create'),
					]
				]
			],
			[
				'name' => 'گزارشات',
				'is_active' => $this->checkIsActive(
					[
						'admin.report.user.register',
						'admin.report.user.incompleteProfile',
						'admin.report.user.general',
						'admin.report.user.birthday',
						'admin.report.user.doestNotHaveOrder',
						'admin.report.user.haveOrder',
						'admin.report.user.haveIncome',


						'admin.report.user.orderList',
						'admin.report.user.show_share_user',
						'admin.report.user.location',
                        'admin.report.user.location',
                        'admin.report.user.package-by-date',
					]
				),
				'icon' => '<i class="fa fa-cog"></i>',
				'link' => '',
				'child' => [
					[
						'name' => 'اطلاعات کلی کاربران',
						'is_active' => $this->checkIsActive([
							'admin.report.user.general',
						]),
						'icon' => '<i class="fa fa-info"></i>',

						'link' => route('admin.report.user.general'),
					],
                    [
                        'name' => 'سهم معرف ',
                        'is_active' => $this->checkIsActive([
                            'admin.report.user.show_share_user',
                        ]),
                        'icon' => '<i class="fa fa-info"></i>',
                        'link' => route('admin.report.user.show_share_user'),
                    ],

                    [
                        'name' => 'سهم معرف بر اساس تاریخ',
                        'is_active' => $this->checkIsActive([
                            'admin.report.user.show_share_user_date',
                        ]),
                        'icon' => '<i class="fa fa-info"></i>',
                        'link' => route('admin.report.user.show_share_user_date'),
                    ],

					[
						'name' => 'ثبت نام کاربران',
						'is_active' => $this->checkIsActive([
							'admin.report.user.register',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.register'),
					],
					[
						'name' => 'کاربران با پروفایل غیر فعال',
						'is_active' => $this->checkIsActive([
							'admin.report.user.incompleteProfile',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.incompleteProfile'),
					],
					[
						'name' => 'تاریخ تولد کاربران',
						'is_active' => $this->checkIsActive([
							'admin.report.user.birthday',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.birthday'),
					],
					[
						'name' => 'کاربران بدون خرید',
						'is_active' => $this->checkIsActive([
							'admin.report.user.doestNotHaveOrder',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.doestNotHaveOrder'),
					],
					[
						'name' => 'کاربران دارای خرید',
						'is_active' => $this->checkIsActive([
							'admin.report.user.haveOrder',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.haveOrder'),
					],
					[
						'name' => 'کاربران با کسب درامد',
						'is_active' => $this->checkIsActive([
							'admin.report.user.haveIncome',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.haveIncome'),
					],
					[
						'name' => 'لیست سفارشات کاربر',
						'is_active' => $this->checkIsActive([
							'admin.report.user.orderList',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.orderList'),
                    ],

                    [
						'name' => 'لیست پروفایل های ناقص',
						'is_active' => $this->checkIsActive([
							'admin.report.user.unCompleateProfile',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.unCompleateProfile'),
					],
					[
						'name' => 'لیست پکیج ها',
						'is_active' => $this->checkIsActive([
							'admin.report.user.package-sells',
						]),
						'icon' => '<i class="fa fa-info"></i>',
						'link' => route('admin.report.user.package-sells'),
					],

//                    [
//                        'name' => 'گزارش مقدار کلی فروش',
//                        'is_active' => $this->checkIsActive([
//                            'admin.report.user.orderList',
//                        ]),
//                        'icon' => '<i class="fa fa-info"></i>',
//                        'link' => route('admin.report.user.orderList'),
//                    ],

                    [
                        'name' => 'کاربران براساس موقعیت مکانی',
                        'is_active' => $this->checkIsActive([
                            'admin.report.user.location',
                        ]),
                        'icon' => '<i class="fa fa-location-arrow"></i>',
                        'link' => route('admin.report.user.location'),
                    ],

                    [
                        'name' => 'میزان فروش محصولات',
                        'is_active' => $this->checkIsActive([
                            'admin.report.user.sells',
                        ]),
                        'icon' => '<i class="fa fa-shopping-bag"></i>',
                        'link' => route('admin.report.user.sells'),
                    ],

                    [
                        'name' => 'فروش پکیج ها بر اساس تاریخ',
                        'is_active' => $this->checkIsActive([
                            'admin.report.user.package-by-date',
                        ]),

                        'icon' => '<i class="fa fa-info"></i>',
                        'link' => route('admin.report.user.package-by-date'),
                    ],


				]
			],
            [
                'name' => 'کانال',
                'is_active' => $this->checkIsActive(
                    [
                        'admin.channel.index',
                        'admin.channel.create',
                    ]
                ),
                'icon' => '<i class="fa fa-users"></i>',
                'link' => route('admin.checkout.index'),
                'child' => [
                    [
                        'name' => 'لیست',
                        'is_active' => $this->checkIsActive([
                            'admin.channel.index',
                        ]),
                        'icon' => '<i class="fa fa-list"></i>',
                        'link' => route('admin.channel.index'),
                    ],
                    [
                        'name' => 'افزودن',
                        'is_active' => $this->checkIsActive([
                            'admin.channel.create',
                        ]),
                        'icon' => '<i class="fa fa-plus"></i>',
                        'link' => route('admin.channel.create'),
                    ],
                ],
            ],
			[
                'name' => 'تسویه حساب',
                'is_active' => !true,
                'icon' => '<i class="nav-icon fa fa-money"></i>',
                'link' => route('admin.checkout.index'),
                'child' => [],
            ],


            [
                'name' => 'ارسال نوتیفیکیشن',
                'is_active' => !true,
                'icon' => '<i class="fa fa-address-book-o"></i>',
                'link' => route('admin.user.show_form_send_notification_to_user'),
                'child' => [],
            ],

            [
                'name' => 'پشتیبانی',
                'is_active' => !true,
                'icon' => '<i class="nav-icon fa fa-support"></i>',
                'link' => route('admin.support.index'),
                'child' => [],
            ],
		];
	}

	/**
	 * @param array $routes
	 * @return bool
	 */
	private function checkIsActive(array $routes): bool
	{
		return in_array(\Route::currentRouteName(), $routes);
	}

	public function compose(View $view)
	{
		$view->with('sidebar', $this->sidebar());
	}
}
