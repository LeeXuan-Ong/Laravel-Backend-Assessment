<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class UsersImport implements ToModel, WithHeadingRow
{
    public function uniqueBy()
    {
        return 'id';
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'id' => $row['id'] ?? null,
            'name'=>$row['name'] ?? null,
            'email'=>$row['email'] ?? null,
            'password'=> Hash::make($row['password']) ?? null,

        ]);
    }

    
}
