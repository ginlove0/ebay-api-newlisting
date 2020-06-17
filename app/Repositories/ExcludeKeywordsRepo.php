<?php
namespace App\Repositories;
use App\FromTitle;
use App\Http\Resources\FromTitleResource;
use App\Repositories\Interfaces\ExcludeKeywordsInterface;
use App\ExcludeKeywords;
use App\Http\Resources\KeywordResource;
use Illuminate\Support\Facades\DB;

class ExcludeKeywordsRepo implements ExcludeKeywordsInterface
{
    public function add($name, $title) {

        $data = new ExcludeKeywords;
        $data->name = $name;
        $data->from_title_id = $title;
        $data->save();

    }

    public function edit() {

    }

    public function index() {
//        $data = ExcludeKeywords::orderBy('name', 'desc')->get();
        return FromTitleResource::collection(FromTitle::with('exclude_keywords')->get());
    }

    public function delete($title_id) : void{
        $title = FromTitle::find($title_id);
        DB::delete('delete from exclude_keywords where from_title_id = ?', [$title->id]);
        $title->delete();
    }
}

