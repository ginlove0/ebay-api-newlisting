<?php
namespace App\Repositories;

use App\Repositories\Interfaces\ExcludeCategoryInterface;
use App\ExcludeCategory;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ItemInterface;
use App\Http\Resources\CategoryResource;

class ExcludeCategoryRepo implements ExcludeCategoryInterface
{

    protected $item_di;
    public function __construct(ItemInterface $item_di)
    {
        $this->item_di = $item_di;
    }


    public function blacklist_category($category, $title)
    {
        $excludeCategory = new ExcludeCategory;
        $excludeCategory->name = $category;
        $excludeCategory->save();
        DB::delete('delete from items where category = ?', [$category]);




        // put this item to blacklist
//        $this->item_di->titleBlackList($title);
    }

    // get all the category blacklist data
    public function index_blacklist_category()
    {
        // $categories = DB::table('exclude_category')->orderBy('name', 'asc')->get();

        // return $categories->toJson();
        $data = ExcludeCategory::orderBy('name', 'desc')->get();

        return CategoryResource::collection($data);
    }

    public function delete($id)
    {
        $category = ExcludeCategory::find($id);
        $category->delete();
    }

}

