<?php

namespace App\Imports;

use App\interventionUploader;
use Maatwebsite\Excel\Concerns\ToModel;

class interventionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return interventionUploader::updateOrCreate(
            [
                //
                'group' => $row[0],
                'division' => $row[1],
                'competency' => $row[2],
                'training' => $row[3]
            ],
            [
                'group' => $row[0],
                'division' => $row[1],
                'competency' => $row[2],
                'training' => $row[3]
            ]
        );
    }
}
