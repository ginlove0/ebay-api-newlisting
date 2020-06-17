<?php

namespace App\Http\Controllers;

use App\Notifications\OneSignalNotification;
use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
//        $oneSignal = new OneSignalNotification();
//        $respone = $oneSignal->send();
//        $url = "https://thumbs2.ebaystatic.com/m/myYhLKe7kuP7isUG0cQRY0g/140.jpg";
//        $url2 = str_ireplace( 'http://', 'https://', $url );
        // $this->item_di->insertAll();
        // $items = $this->ebay_di->call_api('Cisco', 'EBAY-AU');
        // Disk Controllers/RAID Cards
        // $t = $this->item_di->checkCategory('Boosters, Extenders & Antennas');
        // return "$t";
        // return $items;

      return $this->ebay_di->call_api('Cisco', 'EBAY-AU');

//        $this->ebay_di->call_api()
//        return $this->ebay_di->findItem(3312);
    //    return $this->item_di->insertAll();
    }
}
