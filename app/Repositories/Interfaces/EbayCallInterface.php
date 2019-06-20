<?php


namespace App\Repositories\Interfaces;


interface EbayCallInterface
{
//    call api
    public function call_api($query, $siteID);

    public function findItem($id);
}
