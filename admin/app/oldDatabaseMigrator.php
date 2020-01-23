<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class oldDatabaseMigrator extends Model
{
    //
    use SoftDeletes;
    public $primaryKey = 'employeeID';

    public $fillable = ['assessee','assessor','competency','givenLevelID','targetLevelID','weightedScore','role','competencyType','origCreated','origUpdated'];
}
