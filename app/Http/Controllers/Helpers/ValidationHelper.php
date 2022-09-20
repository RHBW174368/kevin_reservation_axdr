<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidationHelper extends Controller
{
    public static function isWeekend($date)
    {
    	return (date('N', strtotime($date)) >= 6);
	}
}
