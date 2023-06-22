<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ReportRequest;
use App\Http\Controllers\Controller;


use App\Http\Requests\Admin\SendNotificationRequest;
use App\Models\Invite;
use App\Models\Node;
use App\Models\Order;
use App\Models\Orderable;
use App\Notifications\ReportNotification;
use App\User;
use Carbon\Carbon;
use DB;
use Kavenegar\Exceptions\ApiException;
use Kavenegar\Exceptions\HttpException;
use Kavenegar\KavenegarApi;
use App\Repositories\{SmsCodeRepository, UserRepositoryImp, OrderRepositoryImp};
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /** @var UserRepositoryImp $userRepo */
    private $userRepo;

    /** @var OrderRepositoryImp $orderRepo */
    private $orderRepo;

    public function __construct(
        UserRepositoryImp $userRepo,
        OrderRepositoryImp $orderRepo
    )
    {
        $this->userRepo = $userRepo;
        $this->orderRepo = $orderRepo;
    }

    public function userGeneralReport()
    {
        $countOfUsersWithIdentifierCode = Invite::all()->count();
        $countOfUsersWithIdentifierCodeOrder = Invite::join('orders', 'invites.user_id' , '=', 'orders.user_id')
            ->distinct('invites.user_id')
            ->pluck('invites.user_id')
            ->count();

        $notCountOfUsersWithIdentifierCodeOrder = User::join('invites', 'users.id' , '!=', 'invites.user_id')
            ->join('orders', 'users.id' , '=', 'orders.user_id')
            ->distinct('users.id')
            ->pluck('users.id')
            ->count();


        return view('admin.report.user.userGeneral', [
            'countOfUsers' => $this->userRepo->count(),
            'countOfUsersThatInviteOthers' => $this->userRepo->getCountOfUsersThatInviteOthers(),
            'countOfUsersWithIdentifierCode' => $countOfUsersWithIdentifierCode,
            'notCountOfUsersWithIdentifierCode' => ($this->userRepo->count() - $countOfUsersWithIdentifierCode),
            'countOfUsersWithIdentifierCodeOrder' => $countOfUsersWithIdentifierCodeOrder,
            'notCountOfUsersWithIdentifierCodeOrder' => $notCountOfUsersWithIdentifierCodeOrder
        ]);
    }

    public function userRegister(ReportRequest $request)
    {
        /** @var array $data */
        $data = [];
        if ($request->has('start') and $request->has('end')) {
            $data['items'] = $this->userRepo->registerBetweenDate(
                new \DateTime($request->get('start')),
                new \DateTime($request->get('end'))
            );
            $data['start_unix_time'] = strtotime($request->get('start'));
            $data['end_unix_time'] = strtotime($request->get('end'));
        }
        return view('admin.report.user.register', $data);
    }

    public function incompleteProfile()
    {
        return view('admin.report.user.incompleteProfile', [
            'items' => $items = $this->userRepo->incompleteProfile()
        ]);
    }

    /**
     *
     * @param ReportRequest $request
     * @return void
     */
    public function userBirthday(ReportRequest $request)
    {
        /** @var array $data */
        $data = [];
        if ($request->has('start') and $request->has('end')) {
            $data['items'] = $this->userRepo->getUsersWhereBirthDayIsInRange(
                new \DateTime($request->get('start')),
                new \DateTime($request->get('end'))
            );
            $data['start_unix_time'] = strtotime($request->get('start'));
            $data['end_unix_time'] = strtotime($request->get('end'));
        }
        return view('admin.report.user.userBirthday', $data);
    }

    public function userDoestNotHaveOrder()
    {
        $this->userRepo->doesNotHaveOrder();

        return view('admin.report.user.doesNotHaveOrder', [
            'items' => $this->userRepo->doesNotHaveOrder()
        ]);
    }

    public function userHaveOrder(ReportRequest $request)
    {
        /** @var array $data */
        $data = [];
        if ($request->has('start') and $request->has('end')) {
            $data['items'] = $this->userRepo->haveOrderBetweenDate(
                new \DateTime($request->get('start')),
                new \DateTime($request->get('end'))
            );
            $data['start_unix_time'] = strtotime($request->get('start'));
            $data['end_unix_time'] = strtotime($request->get('end'));
        }
        return view('admin.report.user.haveOrder', $data);
    }

    public function userHaveIncome(ReportRequest $request)
    {
        return view('admin.report.user.haveIncome', [
            'items' => $this->userRepo->haveIncome()
        ]);
    }

    public function userOrderList(ReportRequest $request)
    {
        $data = [];

        /** @var \Illuminate\Database\Eloquent\Collection $data ['users'] */
        $data['users'] = $this->userRepo->all(['id', 'first_name', 'last_name']);
        if (!$data['users']->count()) {
            setDangerAlertSession('هیچ کاربری در سیستم وجود ندارد.');
            return redirect(
                route('admin.dashboard')
            );
        }
        if ($request->method() === 'POST') {
            /** @var \App\User $user */
            $data['user'] = $this->userRepo->findOneOrFail($request->get('user'));
            $items = $this->orderRepo->getOrdersByUserId($request->get('user'), 'id', 'DESC');
            foreach ($items->items() as $item) {
                $item->send_type = \App\Enums\OrderType::getValue(strtoupper($item->send_type));
                $item->paid_status = ($item->is_paid == 1) ? 'پرداخت شده' : 'پرداخت نشده';
                $item->type = \App\Enums\OrderType::getValue(strtoupper($item->type));
            }
            $data['items'] = $items;
        }
        return view('admin.report.user.orderList', $data);
    }


    public function doestNotHaveCompleteUserProfile()
    {
        $users = $this->userRepo->incompleteProfile()->pluck('id')->toArray();
        $orders = Order::whereIn('user_id', $users)->with('user')->get();
        dd($orders);

    }

    public function userInactiveOrder()
    {
        $orders = Order::all()->pluck('user_id')->toArray();
        $users = User::whereIn('id', $orders)->get();
        dd($users);
    }

    public function userActiveOrder()
    {
        $users = $this->userRepo->getActives()->pluck('id');
        $orders = Order::whereIn('user_id', $users)->with('user')->get();
        dd($orders);
    }

    public function showOrder()
    {

    }

    private function getUser($usersId){
        return User::whereIn('id', $usersId)->get();
    }

    public function sendNotification(SendNotificationRequest $request)
    {
        $users = $this->getUser($request['users']);

        if ($request['type'] == 'sms'){
            $this->sendSmsNotification($users, $request['title'], $request['description']);
        }else{
            $this->sendPush($users, $request['title'], $request['description']);
        }

        return redirect()->route('admin.dashboard', ['send_notification' =>  true]);
    }

    private function sendPush($users, $title, $text){
        $receptor = [];

        foreach ($users as $user){
            if (($user['fcm_token'] != null) && ($user['fcm_token'] != 'empty')){
                $receptor[] = $user['fcm_token'];
            }
        }
        if (count($receptor) != 0){

            $YOUR_TOKEN = 'put your token here ...';
            $YOUR_APP_ID = 'put your app id here ...';

            $ch = curl_init('https://api.pushe.co/v2/messaging/notifications/');

            curl_setopt_array($ch, array(
                CURLOPT_POST  => 1,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: Token " . $YOUR_TOKEN,
                ),
            ));

            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
                'app_ids' => $YOUR_APP_ID,
                'data' => array(
                    'title' => $title,
                    'content' => $text
                ),
                'filters' => array(
                    'device_id' => array(

                    )
                )
            )));

            $result = curl_exec($ch);

            curl_close($ch);

            echo $result;
        }

    }

    private function sendSmsNotification($users, $title, $text)
    {
        $receptor = [];

        foreach ($users as $user){
            $receptor[] = $user['mobile'];
        }

        try {
            $kavenegar = new KavenegarApi(env('KAVENEGAR_API'));

            $sender = env('KAVENEGAR_NUMBER');
            $message = $title."\n".$text;
            $result = $kavenegar->Send($sender,$receptor,$message);

            return true;

        } catch (ApiException $e) {
            echo $e->errorMessage();
        } catch (HttpException $e) {
            echo $e->errorMessage();
        }
    }

    public function getUsersBasedOnLocation(Request $request)
    {
        $provinces = User::all()->groupBy('province')->keys();

        if ($request->method() === 'GET') {
            return view('admin.report.user.userBasedOnLocation')
                ->with('provinces', $provinces);
        } else {
            $items = User::where('province', 'like', '%' . $request->input('province') . '%')
                ->orderBy('score', 'desc')
                ->orderBy('share', 'desc')
                ->get();

            return view('admin.report.user.userBasedOnLocation')
                ->with('provinces', $provinces)
                ->with('items', $items);
        }
    }

    public function showShareUser()
    {
        $nodes = Node::all();

        return view('admin.report.user.getShareUser')
            ->with('nodes', $nodes)
            ->with('date_status', false);

    }

    public function showShareUserDate()
    {
        $nodes = Node::all();

        return view('admin.report.user.getShareUser')
            ->with('nodes', $nodes)
            ->with('date_status', true);

    }

    public function getShareUser(ReportRequest $request)
    {
        $nodes = Node::all();

        $nodeData = Node::where('id', $request['node_id'])->with([
            'prices'=>function($q){
                $q->where('type', 'coin');
            }
        ])->first();

        $queryItems = Orderable::where('nodeable_id', $request['node_id'])
            ->with([
                'order',
                'order.user',
                'order.user.invitedFrom',
            ]);

        if (isset($request['start']) && isset($request['end'])){
            $queryItems = $queryItems->whereBetween('created_at', [$request->get('start'), $request->get('end')]);
        }

        $items = $queryItems->get()->toArray();

        $userArray = [];

        // dd($items);

        foreach ($items as $item){

            if ($item['order'] != null){
                if ($item['order']['user'] != null){
                    if (count($item['order']['user']['invited_from']) != 0){

                        $user = $item['order']['user']['invited_from'][0];

                        if (!array_key_exists($user['id'], $userArray)){

                            $userArray[$user['id']] = [
                                'user' => $user,
                                'counter' => 1
                            ];

                        }else{
                            $userArray[$user['id']]['counter'] ++;
                        }

                    }
                }
            }

        }

        return view('admin.report.user.getShareUser')
            ->with('nodes', $nodes)
            ->with('nodeData', $nodeData)
            ->with('items', $userArray)
            ->with('date_status', $request['date_status']);
    }

    public function getSells(ReportRequest $request)
    {
        if ($request->method() === 'GET') {
            return view('admin.report.user.sells');
        } else {
            $orders = Order::with('user')
                ->whereBetween('created_at', [$request->get('start'), $request->get('end')])
                ->get();

            // dd($orders);
            return view('admin.report.user.sells')->with('orders', $orders);
        }
    }

    public function packageByDate(ReportRequest $request)
    {

      //dd($request);
      $packages = Node::where('is_product',0)->get();
       if ($request->method() === 'GET') {
            //dd($packages);
            return view('admin.report.package.packageByDate',compact('packages'));
       } else {
           //dd($request->start);
            $items = Orderable::where('nodeable_id',$request->package)->whereBetween('created_at',[$request->start,$request->end])
            ->get();

            return view('admin.report.package.packageByDate')
            ->with('items',$items)
            ->with('packages',$packages);
       }
    }


    public function unCompleateProfile(ReportRequest $request)
    {
        $items = User::where('address',null)
        ->orWhere('city',null)
        ->orWhere('job',null)
        ->orWhere('first_name',null)
        ->orWhere('last_name',null)
        ->orWhere('email',null)
        ->get();
        //dd($items[100]);
        return view('admin.report.user.uncompleteprofile',compact('items'));
    }

    public function packageSells(Request $request)
    {
        $packages = Node::where('is_product', 0)->get();

        if ($request->method() === 'GET') {
            return view('admin.report.user.packageSells')->with('packages', $packages);
        } else {
            $request->validate([
                'package' => 'required|exists:nodes,id',
                'type'    => 'required|in:flash,dvd'
            ]);

            // dd($request['type']);

            $orders = Orderable::where('nodeable_id', $request['package'])
                ->where('nodeable_type', $request['type'])
               ->with('order', 'order.user')
                ->get();

            return view('admin.report.user.packageSells')
                ->with('packages', $packages)
                ->with('orders', $orders);
        }
    }
}
