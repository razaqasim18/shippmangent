<?php // Code within app\Helpers\SettingHelper.php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class CustomHelper
{
    public static function ristrictEditor()
    {
        if (Auth::guard('web')->user()->role == 1) {
            return false;
        }
    }
}
