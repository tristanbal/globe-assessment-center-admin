<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class competencyPerRoleTarget extends Model
{
    //
    use SoftDeletes;
    public $fillable = ['roleID','competencyID','competencyTargetID','sourceID'];

    public function role()
    {
        return $this->belongsTo('App\role','roleID');
    }
    public function competency()
    {
        return $this->belongsTo('App\competency','competencyID');
    }
    public function competencyTarget()
    {
        return $this->belongsTo('App\level','competencyTargetID');
    }
    public function source()
    {
        return $this->belongsTo('App\targetSource','sourceID');
    }

}
