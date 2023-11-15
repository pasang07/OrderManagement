<?php

namespace App\Imports;

use App\Models\Model\SuperAdmin\Menulist\Menulist;
use Maatwebsite\Excel\Concerns\ToModel;

class MenulistsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Menulist([
            'title'     => $row[0],
            'overview'    => $row[1],
            'category' => $row[2],
            'price' => $row[3],
            'is_featured' => $row[4],
        ]);
    }
}
