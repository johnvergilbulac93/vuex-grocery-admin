<?php

namespace App\Imports;

use App\gc_product_uom;
use App\gc_product_price;
use Illuminate\Support\Arr;
use App\gc_product_price_history;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;


class PriceChangedImport implements ToCollection
{
    use Importable;

    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

            $check_price_uom_data =  gc_product_price::where('itemcode', '=', intval($row[0]))
                ->where('UOM', '=', $row[2])
                ->where('price_group', '=', $row[6])
                ->exists();

            if ($check_price_uom_data) {

                gc_product_price::where('itemcode', '=', intval($row[0]))
                    ->where('UOM', '=', $row[2])
                    ->where('price_group', '=', $row[6])
                    ->update([
                        'price'             =>  floatval(str_replace(',', '', $row[5])),
                        'price_with_vat'    =>  floatval(str_replace(',', '', $row[5])),
                    ]);

            } else {

                gc_product_price::insert([
                    'itemcode'          =>  intval($row[0]),
                    'UOM'               =>  $row[2],
                    'price'             =>  floatval(str_replace(',', '', $row[5])),
                    'price_with_vat'    =>  floatval(str_replace(',', '', $row[5])),
                    'status'            =>  1,
                    'price_group'       =>  $row[6],
                ]);

            }
        }
    }
}
