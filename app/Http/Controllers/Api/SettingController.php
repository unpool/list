<?php

namespace App\Http\Controllers\Api;

use App\Repositories\SettingRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    private $setting_repo;

    public function __construct(SettingRepository $setting)
    {
        $this->setting_repo = $setting;
    }

    public function index(Request $request)
    {
        $validate = \Validator::make($request->all(), [
            'key' => 'required',
        ], [], [
            'key' => 'کلید'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), JsonResponse::HTTP_BAD_REQUEST);
        }
        return response()->json($this->setting_repo->findOneByOrFail(['key' => $request->get('key')]));
    }
}
