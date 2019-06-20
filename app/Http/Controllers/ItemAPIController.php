<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\EbayCallInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemAPIController extends Controller
{
    //

    public function __construct(EbayCallInterface $ebay_di)
    {
        $this->ebay_di = $ebay_di;
    }

    public function index()
    {
        $data = DB::table('items')->orderBy('itemid', 'desc')->get();
        return $data->toJson();

    }
}
