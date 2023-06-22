<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Enums\SettingType;

class SettingController extends Controller
{

    private $setting_repo;

    public function __construct(SettingRepository $setting)
    {
        $this->setting_repo = $setting;
    }

    public function create(string $key)
    {
        switch ($key) {
            case SettingType::HELPER:
                $value = $this->setting_repo->findOneBy(['key' => $key]);
                return view('admin.setting.helper', ['key' => $key, 'value' => $value]);
        }
    }

    public function store(Request $request, string $key)
    {
        $setting = $this->setting_repo->findOneBy(['key' => $key]);
        if ($setting) {
            $setting->update($request->all());
        } else {
            $this->setting_repo->create(['key' => $key, 'value' => $request->get('value')]);
        }
        return back();
    }
}
