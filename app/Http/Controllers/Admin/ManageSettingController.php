<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Models\Setting;
use App\Utils\ImageManager;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManageSettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:manage_settings,admin', except: ['index']),
        ];
    }

    public function index()
    {
        $settings = Setting::all();
        return view('admin.setting.index', compact('settings'));
    }
    public function update(UpdateSettingRequest $request)
    {
        $data = $request->validated();
        $setting = Setting::find(1);
        $setting->update($data);
        notyf()->success('Settings Updated');
        return redirect()->back();
    }
}
