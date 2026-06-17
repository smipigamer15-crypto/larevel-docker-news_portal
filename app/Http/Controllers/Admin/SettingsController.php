<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
   public function index()
{
    $setting = Setting::firstOrCreate(
    ['id' => 1],
    [
        'site_name' => 'News Panel',
        'theme_color' => '#8b5cf6',
        'sidebar_width' => 260,
    ]
);

    return view(
        'admin.settings',
        compact('setting')
    );
}

public function update(Request $request)
{
    $setting = Setting::first();

    $setting->update([
        'site_name' => $request->site_name,
    ]);

    return back();
}

}
