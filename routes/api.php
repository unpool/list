<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\RadioController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Hash;

Route::group([
    'namespace' => 'Api',
], function () {

   Route::get('test', function () {
       echo Hash::make(9638527);
   });

    //    LoginController
    Route::any('sign-in', 'LoginController@signIn');
    Route::any('send-code', 'LoginController@sendCode');

    // Route::resource('note', 'NoteController');

    //    NodeController
    Route::get('packages', 'NodeController@packages');
    Route::post('get-package', 'NodeController@getPackage');
    Route::post('get-product', 'NodeController@getProduct');
    Route::get('get-sliders', 'NodeController@getSliders');
    Route::get('get-best-package', 'NodeController@getBestPackage');
    Route::get('get-roots', 'NodeController@getRoots');

//    TeacherController
    Route::post('get-teacher', 'TeacherController@getTeacher');
//    ConversationController
    Route::post('get-public-conversation', 'ConversationController@publicConversations');

//    PlanController
    Route::get('plan', 'PlanController@index');

//    SettingController
    Route::post('get-help', 'SettingController@index');



    //loginController
    Route::post('refresh', 'LoginController@refresh');

    Route::group(['middleware' => 'auth.jwt'], function () {

        $noteController = NoteController::class;
        Route::prefix('note')->name('note.')->group(function()use($noteController){
            Route::delete('/{note}', [$noteController, 'destroy'])->name('delete');
            Route::post('/store/{node}', [$noteController, 'store'])->name('store');
            Route::get('/show/{node}' , [$noteController,'show'])->name('show');
            Route::put('/update/{note}' , [$noteController,'update'])->name('update');

        });

        $usercomment = UserController::class;
        Route::prefix('user_comment')->name('user_comment.')->group(function()use($usercomment){
            Route::get('/comments' , [$usercomment,'index'])->name('index');
        });

        $radiocontroller = RadioController::class;
        Route::prefix('radio')->name('radio.')->group(function()use($radiocontroller){
            Route::get('/radio' , [$radiocontroller,'index'])->name('index');
            Route::get('/radio/{radio}' , [$radiocontroller,'single'])->name('single');
        });


        //loginController
        Route::post('logout', 'LoginController@logout');
        Route::post('get-user', 'LoginController@getAuthUser');
        Route::post('validation-invite-code', 'LoginController@validationInviteCode');
        Route::get('get-invited', 'LoginController@getInvited');

        //UserController
        Route::post('update-user', 'UserController@update');
        Route::post('set-imei', 'UserController@SetImei');
        Route::get('your-account', 'UserController@yourAccount');
        Route::get('get-users-by-score', 'UserController@getUsersByScore');

        //AccountController
        Route::post('create-account', 'AccountBankController@create');
        Route::get('get-account', 'AccountBankController@index');
        Route::post('delete-account', 'AccountBankController@delete');

        //ConversationController
        Route::post('create-conversation', 'ConversationController@create');
        Route::post('get-private-conversation', 'ConversationController@privateConversation');

        //OrderController
        Route::post('charge-wallet', 'OrderController@chargeWallet');

        // Route::post('check-wallet', 'OrderController@checkWallet');
        Route::post('create-order', 'OrderController@createOrder');
        Route::post('payment-wallet', 'OrderController@paymentWallet');
        Route::post('payment-card', 'OrderController@paymentCard');
        Route::post('get-orders', 'OrderController@getOrders');
        Route::post('get-order', 'OrderController@getOrder');
        Route::post('check-permission', 'OrderController@checkPermission');
        Route::post('payment','OrderController@payment');
        Route::get('download/{node_id}/{file_name}','OrderController@download');

        //checkoutController
        Route::post('checkout','CheckoutController@store');
        Route::get('get-checkouts','CheckoutController@index');

        Route::get('get-support','SupportController@support_list');
        Route::post('view-support','SupportController@support_view');
        Route::post('add-support', 'SupportController@support_add');

        Route::post('payment', 'OrderController@payment');
        Route::get('download/{node_id}/{file_name}', 'OrderController@download');

        //checkoutController
        Route::post('checkout', 'CheckoutController@store');
        Route::get('get-checkouts', 'CheckoutController@index');

        Route::get('get-support', 'SupportController@support_list');
        Route::post('view-support', 'SupportController@support_view');
        Route::post('add-support', 'SupportController@support_add');

        //TicketController
        Route::get('tickets', 'TicketController@index');
        Route::post('tickets', 'TicketController@store');
        Route::delete('tickets/{ticket}', 'TicketController@destroy');


        //TicketController
        Route::get('chance-wheels', 'ChanceWheelController@index');
        Route::post('wheeling', 'ChanceWheelController@wheeling');

        //DipositController
        Route::get('deposits', 'DepositController@getDepositRequests');
        Route::post('deposit/request', 'DepositController@depositRequest');

        // Channel
        Route::get('get_all_channel_user', 'ChannelUserController@getAllChannelUser');
        Route::get('show_massage_channel/{channel}', 'ChannelUserController@showMassageChannel');
    });

    Route::post('getDataPaymentCheck','OrderController@getDataPaymentCheck');
});

