<?php

namespace App;

use App\FromTitle;
use Illuminate\Database\Eloquent\Model;

class ExcludeKeywords extends Model
{
    //
    protected $table = 'exclude_keywords';

    protected $fillable = ['id', 'name', 'from_title_id'];


    public function from_title()
    {
      return $this->belongsTo(FromTitle::class, 'from_title_id', 'id');
    }

}
