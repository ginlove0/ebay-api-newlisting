<?php

namespace App\Http\Controllers;

use App\Events\MessagePushed;
use App\Repositories\Interfaces\EbayCallInterface;
use Illuminate\Http\Request;
use App\Item;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function __construct(EbayCallInterface $ebay_di)
    {
        $this->ebay_di = $ebay_di;
    }

    //
    public function index()
    {
        $data = DB::table('items')->orderBy('itemid', 'desc')->get();
        return view('home', ["data"=>$data]);

    }

    public function items($id)
    {
        $data = $this->ebay_di->findItem($id);
//        $data = $this->ebay_di->findItem('312664642428');
//        return $data;
        $check = $data['Ack'];
        if($check == 'Success') {
            return view('show', ["data"=>$data]);
        }
    }

    public function itemsAPI($id)
    {
        $data = $this->ebay_di->findItem($id);
//        $data = $this->ebay_di->findItem('312664642428');
//        return $data;
        $check = $data['Ack'];
        if($check == 'Success') {
            return $data;
        }
    }
}
