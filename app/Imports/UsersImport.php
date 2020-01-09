<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row['name'],
            'email'    => $row['email'],
            'birthday'    => $row['birthday'],
            'admission'    => $row['admission'],
            'position'    => $row['position'],
            'sector'    => $row['sector'],
            'education'    => $row['education'],
            'place_of_birth'    => $row['place_of_birth'],
            'university'    => $row['university'],
            'is_admin'    => $row['is_admin'],
            'password' => \Hash::make($row['password']),
        ]);
    }
}
