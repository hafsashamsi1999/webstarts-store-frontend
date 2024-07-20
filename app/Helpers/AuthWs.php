<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
/**
 * By Kashif
 * 23 Nov 2023
 * A general Helper class for Auth.
 */
class AuthWs
{
    public static function valid()
    {
        if(Cookie::has('userid') && Cookie::has('username')) {
            return true;
        } else {
            return false;
        }
    }
}
