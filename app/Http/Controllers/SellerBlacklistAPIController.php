<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ExcludeSellerInterface;

class SellerBlacklistAPIController extends Controller
{

    protected $seller_di;
    public function __construct(ExcludeSellerInterface $seller_di)
    {
        $this->seller_di = $seller_di;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->seller_di->index();
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
            $this->seller_di->add($request->data);
            return response()->json(["success"=>"Success put the seller to the blacklist"], 201);

        } catch (QueryException $ex) {
            return response()->json(["error"=>"Seller already in the blacklist"], 400);
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
            $this->seller_di->delete($id);
            return response()->json(["success"=>"Success remove the seller from the blacklist"], 201);

        } catch (QueryException $ex) {
            return response()->json(["error"=>"User error"], 400);
        }
    }
}
