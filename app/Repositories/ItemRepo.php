<?php


namespace App\Repositories;


use App\Builders\ItemBuilder;
use App\Item;
use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Support\Facades\Log;

class ItemRepo implements ItemInterface
{

    public function __construct(EbayCallInterface $ebay_di)
    {
        $this->ebay_di = $ebay_di;
    }

//    public function insert($id, $title, $price, $shipping, $subtitle, $startTime, $endTime, $from_site, $description, $picture, $condition_item, $has_seen)
//    {
//
//
//    }
    public function insertAll()
    {

        $temp = [];
//        call the api to get all the item
        $ebaySite = ["EBAY-AU", "EBAY-US"];
        foreach ($ebaySite as $site) {
        $data = $this->ebay_di->call_api("Cisco", $site);
        $items = $data['findItemsAdvancedResponse'][0]['searchResult'][0]['item'];
//
        foreach ($items as $item)
        {
            $id = $item['itemId'][0];
            $title =  $item['title'][0];
            $shipping_cost =  array_key_exists('shippingServiceCost',$item['shippingInfo'][0]) ? $item['shippingInfo'][0]['shippingServiceCost'][0]['__value__'] : '0';
            $condition_item = $item['condition'][0]['conditionDisplayName'][0];
            $startTime = $item['listingInfo'][0]['startTime'][0];
            $endTime = $item['listingInfo'][0]['endTime'][0];
            $picture = array_key_exists('galleryURL', $item) ? $item['galleryURL'][0] : 'http://ultimatekitpvpserver.weebly.com/uploads/8/9/1/1/89117056/none-flowers_orig.jpg';
            $price =  $item['sellingStatus'][0]['currentPrice'][0]['__value__'];
            $site = $item['globalId'][0] ;

            try {
            $newItem = (new ItemBuilder)
                ->addId($id)
                ->setTitle($title)
                ->setDescription($title)
                ->addEnd_time($endTime)
                ->addStart_time($startTime)
                ->addSite($site)
                ->setPicture($picture)
                ->setItem_condition($condition_item)
                ->addShippingCcost($shipping_cost)
                ->setPrice($price)
                ->setHasSeen(false)
                ->save();
            array_push($temp,
                ["id"=>$id,
                    "title"=>$title,
                    "price"=>$price,
                    "from_site"=>$site,
                    "shipping_cost"=>$shipping_cost,
                    "picture"=>$picture,
                    "item_condition"=>$condition_item,

                    ]
            );
            } catch(\Illuminate\Database\QueryException $ex)
            {
                Log::error('Error at insertAll');
                Log::error($ex);
            }
        }

        }
        return $temp;
    }
}
