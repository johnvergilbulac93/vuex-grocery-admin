<?php

namespace App\Imports;

use App\gc_product_price;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;


class PriceChangedImport implements ToCollection, SkipsOnFailure
{
    use Importable, SkipsFailures;

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
    public function onFailure(Failure ...$failure)
    {
        return 'some fields is empty';
    }
}
