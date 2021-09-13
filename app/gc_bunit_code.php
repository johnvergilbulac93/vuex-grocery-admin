<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gc_bunit_code extends Model
{
    protected $table = 'locate_business_units';

    public function unfound()
    {
           return $this->hasMany('App\GCUnfoundItem', 'bu_id', 'bunit_code');
    }

}
