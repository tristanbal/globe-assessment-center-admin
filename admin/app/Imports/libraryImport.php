<?php

namespace App\Imports;

use App\competencyUploader;
use Maatwebsite\Excel\Concerns\ToModel;

class libraryImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return competencyUploader::updateOrCreate(
            [
                //
                'competencyNames' => $row[3]
            ],
            [
                'clusters' => $row[0],
                'subclusters' => $row[1],
                'talentsegments' => $row[2],
                'competencyNames' => $row[3],
                'competencyElements' => $row[4],
                'definitions' => $row[5],
                'levelOne' => $row[6],
                'levelTwo' => $row[7],
                'levelThree' => $row[8],
                'levelFour' => $row[9],
                'levelFive' => $row[10]
            ]
        );
    }
}
