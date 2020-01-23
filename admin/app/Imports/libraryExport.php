<?php

namespace App\Imports;

use App\competencyUploader;
use Maatwebsite\Excel\Concerns\ToModel;

class libraryExport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new competencyUploader([
            //
        ]);
    }
}
