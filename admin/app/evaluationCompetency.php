<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class evaluationCompetency extends Model
{
    //
    use SoftDeletes;
    public $fillable = ['evaluationID','competencyID','givenLevelID','targetLevelID','weightedScore','competencyTypeID','verbatim','additional_file','created_at','updated_at'];
    public function evaluation()
    {
        return $this->belongsTo('App\evaluation','evaluationID');
    }

    public function competency()
    {
        return $this->belongsTo('App\competency','competencyID');
    }

    public function competencyType()
    {
        return $this->belongsTo('App\competencyType','competencyTypeID');
    }

    public function givenLevel()
    {
        return $this->belongsTo('App\level','givenLevelID');
    }

    public function targetLevel()
    {
        return $this->belongsTo('App\level','targetLevelID');
    }
}
