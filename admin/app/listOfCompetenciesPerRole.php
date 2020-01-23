<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class listOfCompetenciesPerRole extends Model
{
    use SoftDeletes;
    public $fillable = ['groupID', 'roleID', 'competencyID', 'competencyTypeID','targetLevelID'];

    public function role()
    {
        return $this->belongsTo('App\role','roleID');
    }

    public function group()
    {
        return $this->belongsTo('App\group','groupID');
    }

    public function competency()
    {
        return $this->belongsTo('App\competency','competencyID');
    }

    public function competencyType()
    {
        return $this->belongsTo('App\competencyType','competencyTypeID');
    }

    public function target()
    {
        return $this->belongsTo('App\level','targetLevelID');
    }

}
