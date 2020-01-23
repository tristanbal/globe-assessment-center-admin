<?php

namespace App\Imports;

use App\oldDatabaseMigrator;
use Maatwebsite\Excel\Concerns\ToModel;

class migratorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return oldDatabaseMigrator::updateOrCreate(
            [
            //
                'assessee' => $row[0],
                'assessor' => $row[1],
                'competency' => $row[2],
                'competencyType' => $row[7],
                'role' => $row[6]
            ],
            [
                'assessee' => $row[0],
                'assessor' => $row[1],
                'competency' => $row[2],
                'competencyType' => $row[7],
                'role' => $row[6],
                'givenLevelID' => $row[3],
                'targetLevelID' => $row[4],
                'weightedScore' => $row[5],
                'origCreated' => $row[8],
                'origUpdated' => $row[9]
            ]
        );
    }
}
