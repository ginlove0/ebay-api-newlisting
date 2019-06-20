<?php


namespace App\Builders;


use App\Item;

class ItemBuilder
{
    private $item;

    public function __construct()
    {
        $this->item = new Item;
    }

    public function addId($id)
    {
        $this->item->id = $id;
        return $this;
    }

    public function setTitle($title)
    {
        $this->item->title = $title;
        return $this;
    }

    public function setItem_condition($item_condition)
    {
        $this->item->item_condition = $item_condition;
        return $this;
    }

    public function setPrice($price)
    {
        $this->item->price = $price;
        return $this;
    }

    public function addSite($from_site)
    {
        $this->item->from_site = $from_site;
        return $this;
    }

    public function addShippingCcost($shipping_cost)
    {
        $this->item->shipping_cost = $shipping_cost;
        return $this;
    }

    public function setDescription($description)
    {
        $this->item->description = $description;
        return $this;
    }

    public function setPicture($picture)
    {
        $this->item->picture = $picture;
        return $this;
    }

    public function setHasSeen($has_seen)
    {
        $this->item->has_seen = $has_seen;
        return $this;
    }

    public function addStart_time($start_time)
    {
        $this->item->start_time = $start_time;
        return $this;
    }

    public function addEnd_time($end_time)
    {
        $this->item->end_time = $end_time;
        return $this;
    }

    public function save()
    {
        $this->item->save();
        return $this;
    }
}
