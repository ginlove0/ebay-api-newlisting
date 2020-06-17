<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    //

//    use SoftDeletes;

    protected $table = "items";

    public $incrementing = false;

    protected $fillable = ['id', 'itemid', 'title', 'item_condition'];

    public static function selectToDisplay()
    {
        DB::select('
        Select item_condition, price, start_time, end_time, title, from_site, shipping_cost, picture
        from items
        ');
    }

}
