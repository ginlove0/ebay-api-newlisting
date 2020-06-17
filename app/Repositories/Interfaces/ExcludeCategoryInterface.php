<?php
namespace App\Repositories\Interfaces;

interface ExcludeCategoryInterface
{
    public function blacklist_category($category, $title);

    public function index_blacklist_category();

    public function delete($id);
}

