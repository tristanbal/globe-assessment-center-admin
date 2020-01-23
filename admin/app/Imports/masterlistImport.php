<?php

namespace App\Imports;

use App\masterlist;
use Maatwebsite\Excel\Concerns\ToModel;

class masterlistImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return masterlist::updateOrCreate(
            [
                //
                'employeeID' => $row[4]
            ],
            [
                'groups' => $row[0],
                'divisions' => $row[1],
                'departments' => $row[2],
                'sections' => $row[3],
                'employeeID' => $row[4],
                'lastname' => $row[5],
                'firstname' => $row[6],
                'middlename' => $row[7],
                'nameSuffix' => $row[8],
                'roles' => $row[9],
                'bands' => $row[10],
                'supervisorID' => $row[11],
                'email' => $row[12],
                'phone' => $row[13]
            ]
        ); 
    }
}
