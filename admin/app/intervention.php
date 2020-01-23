<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class intervention extends Model
{
    //
    use SoftDeletes;
    public $fillable = ['groupID','divisionID','competencyID','trainingID'];

    public function group()
    {
        return $this->belongsTo('App\group','groupID');
    }
    public function division()
    {
        return $this->belongsTo('App\division','divisionID');
    }
    public function competency()
    {
        return $this->belongsTo('App\competency','competencyID');
    }
    public function training()
    {
        return $this->belongsTo('App\training','trainingID');
    }

}
