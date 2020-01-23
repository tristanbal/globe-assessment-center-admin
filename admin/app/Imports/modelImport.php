<?php

namespace App\Imports;

use App\competencyPerRoleUploader;
use Maatwebsite\Excel\Concerns\ToModel;

class modelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return competencyPerRoleUploader::updateOrCreate(
            [
            //
                'groupNames' => $row[0],
                'roleNames' => $row[1],
                'competencyNames' => $row[2]
            ],
            [
                'groupNames' => $row[0],
                'roleNames' => $row[1],
                'competencyNames' => $row[2],
                'priorities' => $row[3],
                'targetWeights' => $row[4]
            ]
        );
    }
}
