<?php


namespace App\Repositories;
use App\Repositories\Interfaces\EbayCallInterface;

class EbayCallRepo implements EbayCallInterface
{

    public function call_api($query, $siteID)
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
        $site = $siteID;

        $apicall = "$endpoint?OPERATION-NAME=findItemsAdvanced"
            . "&SERVICE-VERSION=1.0.0"
            . "&GLOBAL-ID=$site"
            . "&SECURITY-APPNAME=$appID" //replace with your app id
            . "&paginationInput.entriesPerPage=50"
            . "&paginationInput.pageNumber=$pageNumber"
            . "&keywords=$query"
            . "&sortOrder=StartTimeNewest"
            . "&RESPONSE-DATA-FORMAT=$responseEncoding"
            . "&REST-PAYLOAD";

        $client = new \GuzzleHttp\Client();
//
        $resp = $client->get($apicall);
//
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
