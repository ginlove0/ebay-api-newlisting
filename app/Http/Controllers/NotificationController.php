<?php

namespace App\Http\Controllers;

use App\Notifications\iosNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    //
    public function index(Request $request)
    {
//        ExponentPushToken[b_4jwdMwgSkUpN9lZKsxsA]
//        DB::insert('insert into expo_key (value) values (?)', ['ExponentPushToken[b_4jwdMwgSkUpN9lZKsxsA]']);
//        Log::debug($request);
        return ['hello'=>'hello'];
    }
}
