<?php

namespace App\Http\Controllers;

use App\Events\MessagePushed;
use App\Item;
use Illuminate\Http\Request;
use LRedis;
class SocketController extends Controller
{
    //

    public function index()
    {
        return view('socket/index');
    }

    public function sendMessage(){
        $data = Item::all();
        event(new MessagePushed($data));
    }
}
