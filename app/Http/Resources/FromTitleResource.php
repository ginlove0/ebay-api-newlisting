<?php

namespace App\Http\Resources;

use App\Http\Resources\KeywordResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FromTitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'exclude_keywords' => KeywordResource::collection($this->exclude_keywords),
          ];
    }
}
