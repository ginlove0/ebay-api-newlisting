<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ExcludeCategoryInterface;

class CategoryBlacklistAPIController extends Controller
{

    protected $exCategory_di;
    public function __construct(ExcludeCategoryInterface $exCategory_di)
    {
        $this->exCategory_di = $exCategory_di;
    }
    //


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->exCategory_di->index_blacklist_category();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $category = $request->category;
            $title = $request->title;
            $this->exCategory_di->blacklist_category($category, $title);
            return response()->json(["success" => "Success put the category to the blacklist"], 201);
        } catch (QueryException $ex) {
            return response()->json(["error" => "Category already in the blacklist"], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
           $this->exCategory_di->delete($id);
            return response()->json(["success" => "Success delete the category from the blacklist"], 201);
        } catch (QueryException $ex) {
            return response()->json(["error" => "User error"], 400);
        }

    }
}
