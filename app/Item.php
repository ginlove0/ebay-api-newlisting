<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    //

    protected $table = "items";

    public $incrementing = false;

    public static function selectToDisplay()
    {
        DB::select('
        Select item_condition, price, start_time, end_time, title, from_site, shipping_cost, picture
        from items
        ');
    }

}
