<?php

namespace App\Http\Controllers;

use App\FromTitle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\KeywordResource;
use Illuminate\Database\QueryException;
use App\Repositories\Interfaces\ExcludeKeywordsInterface;
use App\ExcludeKeywords;
use App\Http\Resources\FromTitleResource;

class KeywordAPIController extends Controller
{
    protected $keyword_di;
    public function __construct(ExcludeKeywordsInterface $keyword_di)
    {
        $this->keyword_di = $keyword_di;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->keyword_di->index();
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
            $fromTitle = new FromTitle;
            $fromTitle->title = $request->title;
            $fromTitle->save();
            foreach ($request->data as $keyword) {
                $this->keyword_di->add($keyword, "$fromTitle->id");
            }
            return response()->json($request->data, 200);
        } catch (QueryException $ex) {
            return response()->json(["error"=>"Can't store that keyword"], 400);
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
            $this->keyword_di->delete($id);
            return response()->json(["success"=>"Successfully delete the keywords"],200);

        } catch (\ErrorException $ex) {
            return response()->json(["error"=>"Can't delete the keywords"],400);
        }
    }

    public function calculateExcludeMatch()
    {
        $word = strtoupper("2 X Axiom Cisco GLC-FE-100FX-RGD= Compatible");
        if (strpos($word, strtoupper('Cisco fewd')) !== false) {
            return 'true';
        }
        return FromTitleResource::collection(FromTitle::with('exclude_keywords')->get());
    }
}
