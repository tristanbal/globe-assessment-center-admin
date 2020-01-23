<?php

namespace App\Imports;

use App\masterlist;
use Maatwebsite\Excel\Concerns\ToModel;

class masterlistExport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return masterlist::all();
    }
}
