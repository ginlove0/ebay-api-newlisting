<?php

namespace App\Repositories\Interfaces;

interface ExcludeKeywordsInterface
{
    public function add($name, $title);

    public function edit();

    public function index();

    public function delete($title_id) : void;
 }
