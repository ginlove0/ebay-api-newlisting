<?php


namespace App\Repositories;


use App\ExcludeSeller;
use App\Item;
use App\Repositories\Interfaces\ExcludeSellerInterface;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\SellerResource;

class ExcludeSellerRepo implements ExcludeSellerInterface
{
    public function index()
    {
        return SellerResource::collection(ExcludeSeller::all());
    }

    public function add($seller)
    {
        $excludeSeller = new ExcludeSeller;
        $excludeSeller->name = $seller;
        $excludeSeller->save();

        DB::insert('INSERT INTO excludes (name)
            SELECT title as name FROM items WHERE seller = ?', [$seller]);
        DB::delete('delete from items where seller = ?', [$seller]);
//        $item = Item::where('seller', $seller)->get();
    }


    public function delete($id)
    {
        $data = ExcludeSeller::find($id);
        $data->delete();
    }
}
