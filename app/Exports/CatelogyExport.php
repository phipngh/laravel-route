<?php

namespace App\Exports;

use App\Catelogy;
use Maatwebsite\Excel\Concerns\FromCollection;

class CatelogyExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Catelogy::all();
    }
}
