<?php


namespace App\Repositories\Interfaces;


interface ExcludeSellerInterface
{
    // index of all blacklist seller
    public function index();

//  add seller to blacklist
    public function add($seller);

//  delete seller from blacklist
    public function delete($id);
}
