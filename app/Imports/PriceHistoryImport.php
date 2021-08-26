<?php

namespace App\Imports;

use App\gc_product_price;
use App\gc_product_price_history;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;

class PriceHistoryImport implements ToCollection
{

    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $data_check =  gc_product_price_history::where('itemcode', '=', intval($row[0]))
                ->where('UOM', '=', $row[2])
                ->where('price_group', '=', $row[6])
                ->exists();
            // $data_check_price  =  gc_product_price::where('itemcode', '=', intval($row[0]))
            //     ->where('UOM', '=', $row[2])
            //     ->where('price_group', '=', $row[6])
            //     ->exists();
            $price =  gc_product_price::where('itemcode', '=', intval($row[0]))
                ->where('UOM', '=', $row[2])
                ->where('price_group', '=', $row[6])
                ->first();


            if ($data_check) {

                gc_product_price_history::where('itemcode', intval($row[0]))
                    ->where('UOM', $row[2])
                    ->where('price_group', '=', $row[6])
                    ->update([
                        'prev_price'            =>   floatval(str_replace(',', '', $price->price_with_vat)),
                        'new_price'             =>   floatval(str_replace(',', '', $row[5])),
                        'update_at'             =>   date('Y-m-d H:i:s')
                    ]);

            } else {

                gc_product_price_history::insert([
                    'prev_price'        =>   floatval(str_replace(',', '', $price->price_with_vat)),
                    'new_price'         =>   floatval(str_replace(',', '', $row[5])),
                    'itemcode'          =>   intval($row[0]),
                    'UOM'               =>   $row[2],
                    'update_at'         =>   date('Y-m-d H:i:s'),
                    'price_group'       =>   $row[6]
                ]);
            }
        }
    }
}
