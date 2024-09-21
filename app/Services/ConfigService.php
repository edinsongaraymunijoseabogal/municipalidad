<?php

namespace App\Services;

use App\Models\Setting;

class ConfigService
{
    public static function get($key, $default = null)
    {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
