<?php


namespace App\Repositories;
use App\Repositories\Interfaces\EbayCallInterface;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EbayCallRepo implements EbayCallInterface
{

    public function call_api($query, $siteID)
    {
        //        Get the endpoint in .env
        $endpoint = env('EBAYENDPOINT', '');
//        Get the Ebay Application ID from .env
        $appID = env('EBAYAPPID', '');
        $appID2 = env('EBAYAPPID2', '');
//      Get JSON type rather than XML
        $responseEncoding = 'JSON';

//        page number always be one
        $pageNumber = 1;
//        Need to put this in database
        $site = $siteID;


        $data = (array) DB::select('select * from exclude_sellers');
        $excludeSeller = '';
        if(count($data) > 0) {
            $excludeSeller .= '&itemFilter(0).name=ExcludeSeller';
            for ($index = 0; $index < count($data); $index++) {
                $excludeSeller .= '&itemFilter(0).value(' . $index . ')=' . $data[$index]->name;
            }
        }


        $apicall = "$endpoint?OPERATION-NAME=findItemsAdvanced"
            . "&SERVICE-VERSION=1.0.0"
            . "&SITEID=$site"
            . "&SECURITY-APPNAME=$appID" //replace with your app id
            . "&paginationInput.entriesPerPage=25"
            . "&paginationInput.pageNumber=$pageNumber"
            . "&keywords=$query"
            . "&sortOrder=StartTimeNewest"
            . "&outputSelector=SellerInfo"
            . "&RESPONSE-DATA-FORMAT=$responseEncoding"
            . "&REST-PAYLOAD";

        $client = new \GuzzleHttp\Client();
        try {
            $resp = $client->get($apicall);
//            Log::info($resp, ['loloooooo']);

        } catch (ServerException $ex) {
            $apicall = "$endpoint?OPERATION-NAME=findItemsAdvanced"
                . "&SERVICE-VERSION=1.0.0"
                . "&SITEID=$site"
                . "&SECURITY-APPNAME=$appID2" //replace with your app id
                . "&paginationInput.entriesPerPage=25"
                . "&paginationInput.pageNumber=$pageNumber"
                . "&keywords=$query"
                . "&sortOrder=StartTimeNewest"
                . "&outputSelector=SellerInfo"
                . "&RESPONSE-DATA-FORMAT=$responseEncoding"
                . "&REST-PAYLOAD";

            $resp = $client->get($apicall);
        }
        $data = json_decode($resp->getBody(), true);

        return $data;
    }


    public function findItem($id)
    {


        //        Get the endpoint in .env
        $endpoint = env('EBAYENDPOINT', '');
//        Get the Ebay Application ID from .env
        $appID = env('EBAYAPPID', '');
//      Get JSON type rather than XML
        $responseEncoding = 'JSON';

//        page number always be one
        $pageNumber = 1;
//        Need to put this in database


        $apicall = "http://open.api.ebay.com/shopping?callname=GetSingleItem"
            . "&responseencoding=JSON"
            . "&appid=$appID"
            . "&siteid=0"
            . "&version=967"
            . "&ItemID=$id"
            . "&IncludeSelector=Description,ItemSpecifics";

        $client = new \GuzzleHttp\Client();
//
        $resp = $client->get($apicall);
//
        $data = json_decode($resp->getBody(), true);
        return $data;
    }
}
