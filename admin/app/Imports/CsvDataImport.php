<?php

namespace App\Imports;

use App\masterlist;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CsvDataImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach($collection as $collections){
            masterlist::create([
                'groups' => $collections[0],
                'divisions' => $collections[1],
                'departments' => $collections[2],
                'sections' => $collections[3],
                'employeeID' => $collections[4],
                'firstname' => $collections[5],
                'lastname' => $collections[6],
                'middlename' => $collections[7],
                'nameSuffix' => $collections[8],
                'roles' => $collections[9],
                'bands' => $collections[10],
                'supervisorID' => $collections[11],
                'email' => $collections[12],
                'phone' => $collections[13]
            ]);
        }
        //return $collection;
    }

    /*
    public function model(array $row)
    {
        return new masterlist([
            'groups' => $row[0],
            'divisions' => $row[1],
            'departments' => $row[2],
            'sections' => $row[3],
            'employeeID' => $row[4],
            'firstname' => $row[5],
            'lastname' => $row[6],
            'middlename' => $row[7],
            'nameSuffix' => $row[8],
            'roles' => $row[9],
            'bands' => $row[10],
            'supervisorID' => $row[11],
            'email' => $row[12],
            'phone' => $row[13]
        ]);
    }*/
}
