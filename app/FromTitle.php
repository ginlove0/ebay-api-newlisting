<?php

namespace App;

use App\ExcludeKeywords;
use Illuminate\Database\Eloquent\Model;

class FromTitle extends Model
{
    //
    protected $table = 'from_titles';

    protected $fillable = ['id', 'title'];

    public function exclude_keywords()
    {

        return $this->hasMany(ExcludeKeywords::class, 'from_title_id', 'id');
    }
}
