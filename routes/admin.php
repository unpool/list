<?php

use App\Http\Controllers\Admin\RaddioController;

Route::get('dashboard', 'DashboardController')->name('dashboard');


Route::group(['as' => 'user.'], function () {

    Route::get('show_info/{user}', 'UserController@show_info')->name('show_info');
    Route::post('admin_notes/{user}', 'UserController@admin_notes')->name('admin_notes');

    Route::get('send_notification_to_user', 'UserController@showFormSendNotificationToUser')->name('show_form_send_notification_to_user');
    Route::post('send_notification_to_user', 'UserController@sendNotificationToUser')->name('send_notification_to_user');

    Route::get('search-users', [
        'as' => 'searchUsers',
        'uses' => 'UserController@searchUsers',
    ]);


    Route::get('users-invite-users-with-active-profile', [
		'as' => 'usersInviteUsersWithActiveProfile',
		'uses' => 'UserController@usersInviteUsersWithActiveProfile',
	]);
	Route::post('users-invite-other-users-by-count-and-date', [
		'as' => 'usersInviteOtherUsersByCountAndDate',
		'uses' => 'UserController@usersInviteOtherUsersByCountAndDate',
	]);

	Route::group(['prefix' => '{user}/bank-account', 'as' => 'bankAccount.'], function () {
		Route::post('store', [
			'as' => 'store',
			'uses' => "BankAccountController@store",
		]);
		Route::delete('{id}/destroy', [
			'as' => 'destroy',
			'uses' => "BankAccountController@destroy",
		]);
	});
});

Route::group(['prefix' => 'discounts', 'as' => 'discounts.'], function () {
	Route::get('{discount}/edit/completion', [
		'as' => 'edit.completion',
		'uses' => 'DiscountController@editCompletion'
	]);
	Route::patch('{discount}/update/completion', [
		'as' => 'update.completion',
		'uses' => 'DiscountController@updateCompletion'
	]);
});
Route::resource('discounts', 'DiscountController')->except('show');

Route::group(['prefix' => 'user-imie', 'as' => 'userIMIE.'], function () {
	Route::delete('{id}', [
		'as' => 'delete',
		'uses' => 'UserIMIEController@delete'
	]);
});
Route::resource('user', 'UserController');

// NODE
Route::group(['prefix' => 'node', 'as' => 'node.'], function () {
	Route::get('/', [
		'as' => 'index',
		'uses' => 'NodeController@index',
	]);
	Route::get('create', [
		'uses' => 'NodeController@create',
		'as' => 'create'
	]);
	Route::get('{id}/edit', [
		'uses' => 'NodeController@edit',
		'as' => 'edit'
	]);
	Route::put('{id}', [
		'uses' => 'NodeController@update',
		'as' => 'update'
	]);
	Route::post('move', [
		'as' => 'move',
		'uses' => 'NodeController@move',
	]);
	Route::post('store', [
		'as' => 'store',
		'uses' => 'NodeController@store',
	]);
	Route::delete('{id}/delete', [
		'as' => 'delete',
		'uses' => 'NodeController@destroy',
	]);
	// Route::post('rename', [
	// 	'as' => 'rename',
	// 	'uses' => 'NodeController@rename',
	// ]);
	// Route::get('{node}/options', [
	// 	'as' => 'options',
	// 	'uses' => 'NodeController@options',
	// ]);
	// Route::post('{node}/options', [
	// 	'as' => 'options.save',
	// 	'uses' => 'NodeController@optionsSave',
	// ]);

	Route::group(['prefix' => 'best', 'as' => 'best.'], function () {
		Route::get('', [
			'as' => 'index',
			'uses' => 'BestNodeController@index',
		]);
		Route::post('store', [
			'as' => 'store',
			'uses' => 'BestNodeController@store'
		]);
		Route::delete('{id}/destroy', [
			'as' => 'destroy',
			'uses' => 'BestNodeController@destroy',
		]);
	});
});

// PRODUCT
Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
	Route::post('file-upload', [
		'as' => 'fileUpload',
		'uses' => "ProductController@fileUploader"
	]);
	Route::post('{id}/file-download/{mediaId}', [
		'as' => 'fileDownload',
		'uses' => "ProductController@fileDownload"
	]);
	Route::delete('{id}/file-delete/{mediaId}', [
		'as' => 'fileDelete',
		'uses' => "ProductController@fileDelete"
	]);
	Route::post('{id}/{media_id}/change-file-order', [
		'as' => 'changeFileOrder',
		'uses' => 'ProductController@changeFileOrder'
	]);
});
Route::resource('product', 'ProductController');

// SLIDER
Route::group(['prefix' => 'slider', 'as' => 'slider.'], function () {
	Route::get('', [
		'as' => 'index',
		'uses' => 'SliderController@index',
	]);

	Route::get('{id}/edit', [
		'as' => 'edit',
		'uses' => 'SliderController@edit'
	]);

	Route::put('{slider}', [
		'as' => 'update',
		'uses' => 'SliderController@update'
	]);

	Route::get('create', [
		'as' => 'create',
		'uses' => 'SliderController@create',
	]);

	Route::post('store', [
		'as' => 'store',
		'uses' => 'SliderController@store',
	]);

	Route::delete('{slider}', [
		'as' => 'destroy',
		'uses' => 'SliderController@destroy'
	]);

	Route::get('{slider}/download/{file_name}', [
		'as' => 'download',
		'uses' => 'SliderController@download',
	]);
});

Route::resource('user', 'UserController');

Route::resource('admins', 'AdminController');

Route::group(['prefix' => 'teachers', 'as' => 'teachers.'], function () {
	Route::get('', [
		'as' => 'index',
		'uses' => 'TeacherController@index',
	]);
	Route::get('create', [
		'as' => 'create',
		'uses' => 'TeacherController@create',
	]);
	Route::get('{id}/edit', [
		'as' => 'edit',
		'uses' => 'TeacherController@edit',
	]);
	Route::put('{id}/update', [
		'as' => 'update',
		'uses' => 'TeacherController@update',
	]);
	Route::post('store', [
		'as' => 'store',
		'uses' => 'TeacherController@store',
	]);

	// CV
	Route::group(['prefix' => '{id}/cv', 'as' => 'cv.'], function () {
		Route::get('edit', [
			'as' => 'edit',
			'uses' => 'TeacherController@cvEdit',
		]);

		Route::post('update', [
			'as' => 'update',
			'uses' => 'TeacherController@cvUpdate',
		]);

		Route::post('tiny-mce-image-upload', [
			'as' => 'tinyMCEImageUpload',
			'uses' => 'TeacherController@tinyMCEImageUpload',
		]);
	});

	// GROUP
	Route::group(['prefix' => 'group', 'as' => 'group.'], function () {
		Route::get('', [
			'as' => 'index',
			'uses' => 'TeacherGroupController@index'
		]);
		Route::get('create', [
			'as' => 'create',
			'uses' => 'TeacherGroupController@create'
		]);
		Route::post('store', [
			'as' => 'store',
			'uses' => 'TeacherGroupController@store'
		]);
		Route::get('{id}/edit', [
			'as' => 'edit',
			'uses' => 'TeacherGroupController@edit'
		]);
		Route::patch('{id}', [
			'as' => 'update',
			'uses' => 'TeacherGroupController@update'
		]);
	});
});

// radio
Route::group(['prefix' => 'radio', 'as' => 'radio.'], function () {

    Route::get('index', [
        'as' => 'index',
        'uses' => 'RadioController@index',
    ]);
    Route::get('/create', [
        'as' => 'create',
        'uses' => 'RadioController@create',
    ]);

    Route::post('/store', [
        'as' => 'store',
        'uses' => 'RadioController@store',
    ]);

    Route::get('{id}/edit', [
        'as' => 'edit',
        'uses' => 'RadioController@edit',
    ]);

    Route::post('{id}/update', [
        'as' => 'update',
        'uses' => 'RadioController@update',
    ]);

    Route::delete('{id}/delete', [
        'as' => 'delete',
        'uses' => 'RadioController@delete',
    ]);
});

Route::group(['prefix' => 'user_comment', 'as' => 'user_comment.'], function () {

    Route::get('index', [
        'as' => 'index',
        'uses' => 'UserCommentController@index',
    ]);
    Route::get('/create', [
        'as' => 'create',
        'uses' => 'UserCommentController@create',
    ]);

    Route::post('/store', [
        'as' => 'store',
        'uses' => 'UserCommentController@store',
    ]);

    Route::get('{id}/edit', [
        'as' => 'edit',
        'uses' => 'UserCommentController@edit',
    ]);

    Route::post('{id}/update', [
        'as' => 'update',
        'uses' => 'UserCommentController@update',
    ]);

    Route::delete('{id}/delete', [
        'as' => 'delete',
        'uses' => 'UserCommentController@delete',
    ]);
});


//PLAN
Route::resource('order', 'OrderController')->except(['edit', 'update']);
Route::resource('plan', 'PlanController')->except('show');

Route::get('setting/create/{key}', 'SettingController@create')->name('setting.create');
Route::post('setting/store/{key}', 'SettingController@store')->name('setting.store');

// PACKAGES
Route::group(['prefix' => 'package', 'as' => 'package.'], function () {
	Route::delete('{id}/file-delete/{mediaId}', [
		'as' => 'fileDelete',
		'uses' => "PackageController@fileDelete"
	]);
});
Route::resource('package', 'PackageController', [
	'except' => ['show']
]);

Route::get('checkout/status/{checkout_id}', 'CheckoutController@status')->name('checkout.status');
Route::resource('checkout', 'CheckoutController')->only('index');
Route::group(['middleware' => 'web'], function () {
    // Route::auth();
    Route::resource('support', 'SupportController');
});



Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
	Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
		Route::get('general', [
			'as' => 'general',
			'uses' => "ReportController@userGeneralReport"
		]);

        Route::get('show_share_user', [
            'as' => 'show_share_user',
            'uses' => "ReportController@showShareUser"
        ]);


        Route::get('show_share_user_date', [
            'as' => 'show_share_user_date',
            'uses' => "ReportController@showShareUserDate"
        ]);

        Route::post('get_share_user', [
            'as' => 'get_share_user',
            'uses' => "ReportController@getShareUser"
        ]);


        Route::get('incomplete-profile', [
			'as' => 'incompleteProfile',
			'uses' => 'ReportController@incompleteProfile'
		]);
		Route::match(array('GET', 'POST'), 'register', [
			'as' => 'register',
			'uses' => 'ReportController@userRegister'
		]);

		Route::match(array('GET', 'POST'), 'birthday', [
			'as' => 'birthday',
			'uses' => 'ReportController@userBirthday'
		]);

		Route::match(array('GET', 'POST'), 'have-order', [
			'as' => 'haveOrder',
			'uses' => 'ReportController@userHaveOrder'
		]);

		Route::match(array('GET', 'POST'), 'order-list', [
			'as' => 'orderList',
			'uses' => 'ReportController@userOrderList'
		]);

		Route::get('have-income', [
			'as' => 'haveIncome',
			'uses' => 'ReportController@userHaveIncome'
		]);

		Route::get('doest-not-have-order', [
			'as' => 'doestNotHaveOrder',
			'uses' => 'ReportController@userDoestNotHaveOrder'

        ]);

        Route::get('un-compleate-profile', [
			'as' => 'unCompleateProfile',
			'uses' => 'ReportController@unCompleateProfile'
		]);

        Route::get('doest-not-have-complete-user-profile', [
            'as' => 'doest-not-have-complete-user-profile',
            'uses' => 'ReportController@doestNotHaveCompleteUserProfile'
        ]);

        Route::get('user-inactive-order', [
            'as' => 'user-inactive-order',
            'uses' => 'ReportController@userInactiveOrder'
        ]);

        Route::get('user-active-order', [
            'as' => 'user-active-order',
            'uses' => 'ReportController@userActiveOrder'
        ]);

        Route::get('user-identifier-code', [
            'as' => 'user-identifier-code',
            'uses' => 'ReportController@user-identifier-code'
        ]);

        Route::get('user-identifier-code-order', [
            'as' => 'user-identifier-code-order',
            'uses' => 'ReportController@user-identifier-code-order'
        ]);

        Route::get('show-order', [
            'as' => 'show-order',
            'uses' => 'ReportController@showOrder'
        ]);

        Route::post('send-notification', [
            'as' => 'send-notification',
            'uses' => 'ReportController@sendNotification'
        ]);

        Route::match(array('GET', 'POST'), 'users-locations', [
            'as' => 'location',
            'uses' => 'ReportController@getUsersBasedOnLocation'
        ]);

        Route::match(array('GET', 'POST'), 'sells', [
            'as' => 'sells',
            'uses' => 'ReportController@getSells'
        ]);


        Route::match(array('GET', 'POST'), 'package-by-date', [
			'as' => 'package-by-date',
			'uses' => 'ReportController@packageByDate'
		]);

        Route::match(array('GET', 'POST'), 'package-sells', [
            'as' => 'package-sells',
            'uses' => 'ReportController@packageSells'
        ]);

	});
});

// TICKET
Route::group(['prefix' => 'tickets', 'as' => 'tickets.'], function () {
    Route::get('/without-answer', [
        'as' => 'without.answer',
        'uses' => "TicketController@ticketsWithoutAnswer"
    ]);

    Route::get('/answered', [
        'as' => 'answered',
        'uses' => "TicketController@Answered"
    ]);

    Route::get('/answer/{ticket}', [
        'as' => 'answer',
        'uses' => "TicketController@Answer"
    ]);

    Route::post('/answer/{ticket}', [
        'as' => 'answer.question',
        'uses' => "TicketController@answerToQuestion"
    ]);
});

Route::prefix('channel')->name('channel.')->group(function () {
    $channelController = \App\Http\Controllers\Admin\ChannelController::class;

    Route::get('index', [$channelController, 'index'])->name('index');
    Route::get('create', [$channelController, 'create'])->name('create');
    Route::get('show/{channel}', [$channelController, 'show'])->name('show');
    Route::post('store', [$channelController, 'store'])->name('store');
    Route::delete('delete/{channel}', [$channelController, 'delete'])->name('delete');
    Route::patch('update/{channel}', [$channelController, 'update'])->name('update');

    // Send New Massage
    Route::post('sendNewMassage/{channel}', [$channelController, 'sendNewMassage'])
        ->name('send_new_massage');

    Route::post('sendNewFile/{channel}', [$channelController, 'sendNewFile'])
        ->name('send_new_file');

    Route::post('addUserToChannel/{channel}', [$channelController, 'addUserToChannel'])
        ->name('add_user_to_channel');

    Route::get('removeUserAsChannel/{channel}/{user}', [$channelController, 'removeUserAsChannel'])
        ->name('remove_user_as_channel');
});



// CHANCE WHEEL
Route::group(['prefix' => 'chance-wheel', 'as' => 'chance.wheel.'], function () {
    Route::get('/', [
        'as' => 'index',
        'uses' => "ChanceWheelController@index"
    ]);

    Route::get('/create', [
        'as' => 'create',
        'uses' => "ChanceWheelController@create"
    ]);

    Route::post('/store', [
        'as' => 'store',
        'uses' => "ChanceWheelController@store"
    ]);

    Route::get('/edit/{wheel}', [
        'as' => 'edit',
        'uses' => "ChanceWheelController@edit"
    ]);

    Route::post('/update/{wheel}', [
        'as' => 'update',
        'uses' => "ChanceWheelController@update"
    ]);

    Route::post('/destroy/{wheel}', [
        'as' => 'destroy',
        'uses' => "ChanceWheelController@destroy"
    ]);
});


// Deposit
Route::group(['prefix' => 'deposit', 'as' => 'deposit.'], function () {
    Route::get('/', [
        'as' => 'index',
        'uses' => "DepositController@index"
	]);
	Route::post('/payed/{deposit}', [
        'as' => 'payed',
        'uses' => "DepositController@payed"
	]);
	Route::post('/rejected/{deposit}', [
        'as' => 'rejected',
        'uses' => "DepositController@rejected"
    ]);

});
