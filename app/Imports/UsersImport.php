<?php

namespace App\Imports;

use App\Models\Department;
use App\Models\User;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    public function model(array $row): User
    {
        return new User([
            'nik' => $row[1],
            'name' => $row[2],
            'password' => bcrypt($row[3]),
            'dp_id' => Department::where('dp_code', $row[4])->first()->id,
            'role' => $row[5] == 'Kasie/Kabag/Koord' ? 'Kabag' : $row[5],
            'remember_token' => Str::random(10),
        ]);
    }
}
