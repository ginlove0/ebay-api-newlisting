<?php


namespace App;


use Illuminate\Http\Resources\Json\JsonResource;

class ItemResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
