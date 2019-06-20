<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function __construct(EbayCallInterface $ebay_di, ItemInterface $item_di)
    {
        $this->ebay_di = $ebay_di;
        $this->item_di = $item_di;
    }

    //
    public function index()
    {
        return $this->ebay_di->findItem('223558134566');
//        return $this->ebay_di->findItem(3312);
//        return $this->item_di->insertAll();
    }
}
