<?php

namespace App\Imports;

use App\gc_product_item;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class UpdateDescription implements ToCollection
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            gc_product_item::where('itemcode', intval($row[0]))->update(['product_name' => $row[1]]);
        }
    }
}
