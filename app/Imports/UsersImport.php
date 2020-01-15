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
            'date_of_birth'    => $row['date_of_birth'],
            'area'    => $row['area'],
            'main_area'    => $row['main_area'],
            'supervisor'    => $row['supervisor'],
            'admission'    => $row['admission'],
            'position'    => $row['position'],
            'city'    => $row['city'],
            'country'    => $row['country'],
            'education'    => $row['education'],
            'education_institute'    => $row['education_institute'],
            'is_admin'    => $row['is_admin'],
            'password' => \Hash::make($row['password']),
        ]);
    }
}
