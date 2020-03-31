<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile2 extends Model
{ 
    protected $guarded = array('id');

    // 以下を追記
    public static $rules = array(
        'name' => 'required',
        'gender' => 'required',
        'hobby' => 'required',
        'introduction' => 'required',
        
    );
}
