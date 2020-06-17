<?php

namespace App\Http\Controllers;

use App\Events\MessagePushed;
use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ExcludeSellerInterface;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ExcludeCategoryInterface;

class ItemAPIController extends Controller
{
    //

    public function __construct(EbayCallInterface $ebay_di,
                                ItemInterface $item_di)
    {
        $this->ebay_di = $ebay_di;
        $this->item_di = $item_di;
    }

    public function index()
    {
        $data = DB::table('items')->orderBy('itemid', 'desc')->get();
        return $data->toJson();
    }

    public function indexMobile()
    {
        $data = DB::table('items')->orderBy('itemid', 'desc')->paginate(100);
        return $data->toJson();
    }

    public function seen()
    {
        $data = DB::update('update items SET has_seen = true');
        return $data;
    }



    public function show($id)
    {
        $data = $this->ebay_di->findItem($id);
//        $data = $this->ebay_di->findItem('312664642428');
//        return $data;
        $check = $data['Ack'];
        if($check == 'Success') {
           return $data;
        }
    }

    public function blackList(Request $request)
    {
        try {
            $this->item_di->titleBlackList($request->data);
            return response()->json(["success"=>"Success put the item to the blacklist"], 201);

        } catch (QueryException $ex) {
            return response()->json(["error"=>"Item already in the blacklist"], 400);
        }
    }


    public function clearAllData()
    {
        $data = [];
        $this->item_di->truncateData();
        $this->item_di->insertAll();
        // event(new MessagePushed($data));
        return response()->json(["success"=>"Success remove all data"], 201);
    }


    public function excludeKeywords(Request $request)
    {
        return response()->json($request->data);
    }
}
