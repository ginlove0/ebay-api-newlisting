<?php


namespace App\Repositories;


use App\Builders\ItemBuilder;
use App\Exclude;
use App\Item;
use App\Repositories\Interfaces\EbayCallInterface;
use App\Repositories\Interfaces\ItemInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
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
//        the main keyword to query
        $query = 'Cisco';

//        the temp array to push new item and return it
        $temp = [];
//        call the api to get all the item
        $ebaySite = ["EBAY-AU", "EBAY-US"];


//        search with evey ebay site
        foreach ($ebaySite as $site) {
        $data = $this->ebay_di->call_api($query, $site);
        $items = $data['findItemsAdvancedResponse'][0]['searchResult'][0]['item'];
//
        foreach ($items as $item)
        {
            $findItem = Item::where('id', $item['itemId'][0])->first();
            if(empty($findItem))
            {
                $id = $item['itemId'][0];
                $title =  $item['title'][0];
                $shipping_cost =  array_key_exists('shippingServiceCost',$item['shippingInfo'][0]) ? $item['shippingInfo'][0]['shippingServiceCost'][0]['__value__'] : '0';
                $condition_item = array_key_exists('condition', $item) ? $item['condition'][0]['conditionDisplayName'][0] : 'Unknown';
                $startTime = $item['listingInfo'][0]['startTime'][0];
                $endTime = $item['listingInfo'][0]['endTime'][0];
                $picture = array_key_exists('galleryURL', $item) ? $item['galleryURL'][0] : 'http://ultimatekitpvpserver.weebly.com/uploads/8/9/1/1/89117056/none-flowers_orig.jpg';
                $price =  $item['sellingStatus'][0]['currentPrice'][0]['__value__'];
                $site = $item['globalId'][0];
                $seller = $item['sellerInfo'][0]['sellerUserName'][0];
// feed back of the seller
                $feedbackscore = $item['sellerInfo'][0]['feedbackScore'][0];
                $feedbackpercent = $item['sellerInfo'][0]['positiveFeedbackPercent'][0];

                $category = $item['primaryCategory'][0]['categoryName'][0];

                $galaryPlus = array_key_exists('galleryPlusPictureURL', $item) ? $item['galleryPlusPictureURL'][0] : $picture;

                try {
//                check if the blacklist title is in the item
                    $in_exclude = $this->checkItemExclude($title);
                    //check if the blacklist seller is in the item
                    $in_seller_exlcude = $this->checkSellerExclude($seller);

                    $in_category_exclude = $this->checkCategory($category);

                    if(!$in_exclude && !$in_seller_exlcude && !$in_category_exclude && $seller !== '') {
                        $newItem = (new ItemBuilder)
                            ->addId($id)
                            ->setTitle($title)
                            ->setDescription($title)
                            ->addEnd_time($endTime)
                            ->addStart_time($startTime)
                            ->addSite($site)
                            ->setPicture($picture)
                            ->setItem_condition($condition_item)
                            ->addShippingCost($shipping_cost)
                            ->setPrice($price)
                            ->setHasSeen(false)
                            ->add_category($category)
                            ->addSeller($seller)
                            ->addFeedbackPercent($feedbackpercent)
                            ->addFeedbackScore($feedbackscore)
                            ->save();
                        array_push($temp,
                            ["id"=>$id,
                                "title"=>$title,
                                "price"=>$price,
                                "from_site"=>$site,
                                "shipping_cost"=>$shipping_cost,
                                "picture"=>$picture,
                                "item_condition"=>$condition_item,
                                "seller"=>$seller,
                                "galaryPlus" => $galaryPlus,
                                "has_seen" => False,
                                "feedbackScore" => $feedbackscore,
                                "feedbackPercent" => $feedbackpercent,
                                "category" => $category
                            ]
                        );
                    }
                } catch(\Illuminate\Database\QueryException $ex)
                {
                    Log::error('Error at insertAll');
                    Log::error($ex);
                }
            }

        }

        }
        return $temp;
    }

// black list the title
    public function titleBlackList($title)
    {
        DB::delete('delete from items where title = ?', [$title]);
        $exclude = new Exclude;
        $exclude->name = $title;
        $exclude->save();
    }


    public function checkItemExclude($title) {
        $data = DB::table('excludes')->where('name', $title)->get();
//        return count($data);
        if(count($data) > 0)
        {
            return true;
        }
        return false;
    }

    public function checkSellerExclude($seller) {
        $data = DB::table('exclude_sellers')->where('name', $seller)->get();
//        return count($data);
        if(count($data) > 0)
        {
            return true;
        }
        return false;
    }

    public function checkCategory($category) {
        $data = DB::table('exclude_category')->where('name', $category)->get();

        if(count($data) > 0)
        {
            return true;
        }
        return false;

    }




    function excludedItem($sDescription, $sSite = ','){

        $aKeyword = array(
            array('(1000 ports with IEE|15454|3G.?ANTM1919D|10BASE|640-|(9|25).?pin|adds jumbo|access.?point|ad[0-9]+p|ACC-|AIR-(A|P|C|W)| AS50+|ASC-....-|bracket|CAB.?(USB|SS|STACK)|CAB-|CASCO|cd.?rom|certifi|configuration|compact.?flash|compatib|CS.?MARS|console.*.able|converter|dell|DB9.{1,30}RJ45|RJ45.{1,30}DB9|db25.*adapt|db60.*.able|dimm|Dipole.?Antenna|external power.?supply|EC Network|for cisco|fan.?(tray|kit)|frahim|gigastack|GLC-FE-100FX|Linksys|D.?Link|handbook|hub|HWIC-AP-G-A|IEM|Optimizing|Architectur|Interconnecting|Implementation|Jazib Frahim|rack.*mount|MEM-[0-9]+|MEM....-|MC38.0|MIDBAND|PIX.?(520 |501|506|515 )|Omni.?directiona|repair|pigtail|phone ip|Plantronics|POWERDSINE|PWR.{0,8}-|-PWR-AC|power.?supply.?cable|AC.?power.?(cord|cable)|Patch.?Cord|patch.?kabel|PSA|PCMICA|(serial|rollover).?.able|small.?busines|SD2|SFE.?2|SFS.?70|SLM|SOHO|DRAM|teql|term.{2,7}.able|training|T.?shirtMC.?381|yagi|UBR|video.?train| vip| WIC-1NET|WS-G5484|WUSB600|WRT54|WVC)', ''),
            array('(CISCO|CATALYST|genuine).?(675|770|801|806|828|837|876|1802|160|17|250|2650|261. |262. |2912|292|2948|2950|3500|3640|802|.{2,10}cable|.{1,10}mount|antenna|ATA|BPX|CD|CVRIAD|SA |SD|SR|IOS |JXU|KID|MEM|MCS|MDS|mount|NSS|ROMA|Serverkabel|stackwise|WIC-1DSU|WIC-1T|WIC-2T|HWIC-1ADSLI| WIC-4ESW)', ''),
            array('ws-(c|x)(140|190|192|290|2820|292|294|295|3512|3524.?x|3548.?x|4013|5239|4424|4515|5225|501|291)', ''),
            array('(820|1600|1700|2500|2600|2900|2950|3500).*serie', ''),
            array('(15|29|30|34|72|73|800)-[0-9]{1,9}', ''),
            array('^NEUF (Routeur.?|Commutateur) (Ethernet Cisco|de niveau|.{1,4}Service)', ''),
            array('^NEU Cisco (Catalyst|.{1,10}Integrierter Service Router|.{1,15} SFP .mini-GBIC)', ''),
            array('^NEW Cisco .{1,10} Integrated Services Router', ''),
            array('^NUOVO (Ethernet Switch Cisco Catalyst|Wireless Router Cisco|SFP .mini-GBIC. Cisco)', ''),

            array('(IP.?(PHONE|TELEF)| WIC-1ADSL|AIRONET|79[0-9])', 'NAU'),
            array('(CISCO|CATALYST).?(WAP|Express|SPA)', 'NAU')

        );

        if (!preg_match('/(2350|2960|2960g|c2960g|3750|c3750|3560|c3560|c49|4948|as5|glc|v3|hwic|ehwic|vwic3|vwic2|vic|xenpac|x2|nme|nmx|nm-1ge|nm-1t3|npe-g|87|857|180|181|1841|19[0,1,4]+|29|28|38|39|760|79|asa|phone|pvdm2|pvdm3|aim|x67|67|x45|45)/i', $sDescription, $aMatches))
            return true;

        foreach ($aKeyword as $aCriteria){

            $sAllSite = ($aCriteria[1] == '')?',GB,AU,IT,ES,DE,US,FR,CH,AT,ENCA,FRBE,FRCA,IE,NL,NLBE,PH,PL,SG,':$aCriteria[1];
            $sAllSite = ($sAllSite == 'NAU')?',GB,IT,ES,DE,US,FR,CH,AT,ENCA,FRBE,FRCA,IE,NL,NLBE,PH,PL,SG,':$sAllSite;

            if (false === strstr($sAllSite, $sSite))
                continue;

            if (preg_match('/' . $aCriteria[0] . '/i', $sDescription, $aMatches))
                return true;
        }

        return false;
    }


    public function truncateData()
    {
        // TODO: Implement truncateData() method.
        DB::select('truncate table items');
    }
}
