<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News2 extends Model

{
    protected $guarded = array('id');
    public static $rules = array(
        'title' => 'required',
        'body' => 'required',
    );
    //必須項目
    public function histories()
    {
      return $this->hasMany('App\History2');

    }
}
