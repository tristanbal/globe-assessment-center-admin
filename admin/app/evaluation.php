<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class evaluation extends Model
{
    //
    use SoftDeletes;
    public $fillable = ['assessmentID','assesseeEmployeeID','assessorEmployeeID','assesseeRoleID','assessorRoleID','created_at'];
    public function assessment()
    {
        return $this->belongsTo('App\assessment','assessmentID');
    }

    public function assessee()
    {
        return $this->belongsTo('App\employee_data','assesseeEmployeeID');
    }

    public function assessor()
    {
        return $this->belongsTo('App\employee_data','assessorEmployeeID');
    }

    public function assessorRole()
    {
        return $this->belongsTo('App\role','assessorRoleID');
    }

    public function assesseeRole()
    {
        return $this->belongsTo('App\role','assesseeRoleID');
    }
}
