<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'logo'];

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value)
    {
        $setting = self::firstOrCreate(['key' => $key]);
        $setting->value = $value;
        $setting->save();
    }
    
    public static function getLogo($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->logo : $default;
    }
    
    public static function setLogo($key, $logoPath)
    {
        $setting = self::firstOrCreate(['key' => $key]);
        $setting->logo = $logoPath;
        $setting->save();
    }
}