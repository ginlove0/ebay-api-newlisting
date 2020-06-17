<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImportantKeyword;
use App\Http\Resources\ImportantKeywordResource;

class ImportantKeywordAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ImportantKeyword::orderBy('name', 'desc')->get();
        return ImportantKeywordResource::collection($data);
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
            foreach ($request->data as $keyword) {
                $data = new ImportantKeyword;
                $data->name = $keyword;
                $data->save();
            }
            return response()->json($request->data, 200);
        } catch (QueryException $ex) {
            return response()->json(["error"=>"Can't store that keyword", 400]);
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
    }

    public function calculatematch()
    {
        $word = strtoupper("2 X Axiom Cisco GLC-FE-100FX-RGD= Compatible");
        // $title = strtoupper($request->data);

        if (strpos($word, strtoupper('Cisco fewd')) !== false) {
            return 'true';
        }


        $number_of_words = str_word_count($word);
        return $word;
    }
}
