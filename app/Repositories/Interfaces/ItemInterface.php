<?php


namespace App\Repositories\Interfaces;


interface ItemInterface
{
//    insert new item
//    public function insert($id,
//                           $title,
//                           $price,
//                           $shipping,
//                           $subtitle,
//                           $startTime,
//                           $endTime,
//                           $from_site,
//                           $description,
//                           $picture,
//                           $condition_item,
//                           $has_seen);

//    insert new item
    public function insertAll();


//    put the title of the item to blacklist
    public function titleBlackList($title);

//    this function is to check whether the item is in the black list
    public function checkItemExclude($title);

//    this function is to truncate all the data from item at the end of the day
    public function truncateData();

    public function checkCategory($category);
}
