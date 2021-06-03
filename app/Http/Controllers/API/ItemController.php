<?php

namespace App\Http\Controllers\API;

use App\gc_product_item;
use App\gc_product_price;
use App\gc_product_uom;
use App\gc_item_log_available;
use App\gc_product_price_history;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ItemController extends Controller
{

    public function edit_item(Request $request)
    {

        $this->validate($request, [
            'itemcode' => 'required|numeric',
            'product_name' => 'required',
            'status' => 'required'
        ]);
        $update_data = array(
            'itemcode'      => $request->get('itemcode'),
            'product_name'  => strtoupper($request->get('product_name')),
            'status'        => $request->get('status')
        );
        gc_product_item::where('product_id', '=', $request->product_id)->update($update_data);
    }

    public function getItem(Request $request)
    {
                $columns = ['product_id', 'itemcode', 'product_name', 'category_name', 'product_id'];
        // 
        //         $length = $request->input('length');
        //         $column = $request->input('column');
        //         $dir = $request->input('dir');
        //         $searchValue = $request->input('search');
        //         $categoryValue = $request->input('category');
        // 
        //         // dd($categoryValue);
        // 
        //         $query = gc_product_item::with(['items'])->where('status', 'active')->orderBy($columns[$column], $dir);
        // 
        //         if ($searchValue) {
        // 
        //             $query->where(function ($query) use ($searchValue) {
        //                 $query->where('itemcode', 'like', '%' . $searchValue . '%')
        //                     ->orWhere('product_name', 'like', '%' . $searchValue . '%');
        //             });
        //         }
        // 
        //         if ($categoryValue) {
        //             $query->where(function ($query) use ($categoryValue) {
        //                 $query->where('category_name', 'like', '%' . $categoryValue . '%');
        //             });
        //         }
        // 
        //         $projects = $query->paginate($length);
        //         return ['data' => $projects, 'draw' => $request->input('draw')];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');
        $type = $request->input('type');

        $query = gc_product_item::with(['items'])->where('status', 'active')->orderBy($columns[$column], $dir);

        $query2 =  gc_product_item::with(['items'])->where('status', 'active')
            ->whereNotIn('itemcode', function ($query) {
                $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
            })->orderBy($columns[$column], $dir);
        $query3 =  gc_product_item::with(['items'])->where('status', 'active')
            ->whereIn('itemcode', function ($query) {
                $query->select('gc_item_log_availables.itemcode')->from('gc_item_log_availables')->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code);
            })->orderBy($columns[$column], $dir);

        if ($type) {
            if ($type == 1 || $categoryValue) {
                $query2->where(function ($query) use ($categoryValue) {
                    $query->where('category_name', 'like', '%' . $categoryValue . '%');
                });
            }
            if ($type == 2 || $categoryValue) {
                $query3->where(function ($query) use ($categoryValue) {
                    $query->where('category_name', 'like', '%' . $categoryValue . '%');
                });
            }

            if ($type == 1 || $searchValue) {
                $query2->where(function ($query) use ($searchValue) {
                    $query->where('itemcode', 'like', '%' . $searchValue . '%')
                        ->orWhere('product_name', 'like', '%' . $searchValue . '%');
                });
            }
            if ($type == 2 || $searchValue) {
                $query3->where(function ($query) use ($searchValue) {
                    $query->where('itemcode', 'like', '%' . $searchValue . '%')
                        ->orWhere('product_name', 'like', '%' . $searchValue . '%');
                });
            }
        } else {

            if ($searchValue) {
                $query->where(function ($query) use ($searchValue) {
                    $query->where('itemcode', 'like', '%' . $searchValue . '%')
                        ->orWhere('product_name', 'like', '%' . $searchValue . '%');
                });
            }

            if ($categoryValue) {
                $query->where(function ($query) use ($categoryValue) {
                    $query->where('category_name', 'like', '%' . $categoryValue . '%');
                });
            }
        }
        if ($type) {
            if ($type == 1) {
                $projects = $query2->paginate($length);
            }
            if ($type == 2) {
                $projects = $query3->paginate($length);
            }
        } else {
            $projects = $query->paginate($length);
        }

        return $projects;

    }
    public function getCentralItem(Request $request)
    {

        $columns = ['itemcode', 'product_name', 'category_no', 'product_id', 'product_id', 'status', 'product_id'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');

        $query = gc_product_item::with(['item_price'])->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('product_name', 'like', '%' . $searchValue . '%');
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('category_name', 'like', '%' . $categoryValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function countItem()
    {
        return gc_product_item::count();
    }
    public function countPrice()
    {
        return gc_product_price::count();
    }
    public function countUOM()
    {
        return gc_product_uom::count();
    }
    public function create_item(Request $request)
    {

        $this->validate($request, [
            'itemcode' => 'required|numeric',
            'product_name' => 'required',
            'status' => 'required'
        ]);

        $items_data = array(
            'itemcode'      => $request->get('itemcode'),
            'product_name'  =>   strtoupper($request->get('product_name')),
            'quantity'       => $request->get('quantity'),
            'status'        => $request->get('status'),

        );

        gc_product_item::create($items_data);

        $itemcode = array(
            'itemcode'  => $request->get('itemcode')
        );
        gc_product_uom::create($itemcode);
    }
    public function delete_item($id)
    {
        $item = gc_product_item::where('product_id', '=', $id);
        $item->delete();
    }
    public function create_uom(Request $request)
    {
        $this->validate($request, [
            'itemcode_uom'      => 'required|numeric',
            'uom'               => 'required',
            'quantity_uom'      => 'required'

        ]);
        $update_data = array(
            'itemcode'          => $request->get('itemcode_uom'),
            'uom'               => strtoupper($request->get('uom')),
            'qty_per_uom'       => $request->get('quantity_uom'),

        );
        gc_product_uom::where('uom_id', '=', $request->uom_id)->update($update_data);
    }
    public function delete_uom($id)
    {
        $uom = gc_product_uom::where('uom_id', '=', $id);
        $uom->delete();
    }

    public function item_not_available(Request $request)
    {
        // return DB::table('gc_item_log_availables')
        //     ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
        //     ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
        //     ->select('*')
        //     ->where('gc_product_items.status', '=', 'active')
        //     ->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code)
        //     ->paginate();

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_item_log_availables')
            ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
            ->select('*')
            ->where('gc_product_items.status', '=', 'active')
            ->where('gc_item_log_availables.store', '=', Auth::user()->bunit_code)
            ->orderBy('product_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_items.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%');
            });
        }

        $final_result = $query->paginate($length);

        return  $final_result;
    }
    public function item_available_all()
    {
        return DB::table('gc_item_log_availables')
            ->join('gc_product_items', 'gc_product_items.itemcode', '=', 'gc_item_log_availables.itemcode')
            ->join('locate_business_units', 'locate_business_units.bunit_code', '=', 'gc_item_log_availables.store')
            ->select('*')
            ->get();
    }
    public function  tag_item_disable(Request $request)
    {
        gc_item_log_available::insert([
            'itemcode'       => $request->itemcode,
            'store'          => Auth::user()->bunit_code,
            'tag_by'         => Auth::user()->name,
        ]);
    }

    public function tag_item_enable($id)
    {
        gc_item_log_available::where('store','=', Auth::user()->bunit_code)
            ->where('itemcode','=', $id)
            ->delete();
    }

    public function item_Active(Request $request)
    {
        gc_product_item::where('itemcode', $request->itemcode)->update([
            'status'       => 'inactive',
        ]);
    }

    public function item_Inactive(Request $request)
    {
        gc_product_item::where('itemcode', $request->itemcode)->update([
            'status'       => 'active',
        ]);
    }

    public function imageitem(Request $request)
    {
        $this->validate($request, [
            'item_image'      => 'image',
        ]);

        $itemImage = $request->file('item_image');
        $itemCode = $request->itemcode;
        // $imageName = $itemCode . '.' . $itemImage->getClientOriginalExtension();
        $imageName = $itemImage->getClientOriginalName();

        $path = public_path() . '/ITEM-IMAGES/' . $imageName;
        // $path = '../admins.alturush.com/ITEM-IMAGES/' . $imageName;

        if (file_exists($path)) {
            @unlink($path);
        }

        $itemImage->move(public_path('ITEM-IMAGES'), $imageName);
        // $itemImage->move('../admins.alturush.com/ITEM-IMAGES/' , $imageName);

        gc_product_item::where('itemcode', '=', $itemCode)->update([
            'image' => $imageName
        ]);
    }

    public function show_item_disable_per_uom(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
            ->where('gc_product_prices.status', '=', 1)
            ->select('*')
            ->orderBy('price_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_prices.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_prices.UOM', 'like', '%' . $searchValue . '%');
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('gc_product_items.category_name', 'like', '%' . $categoryValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function disable_item_per_uom(Request $request)
    {
        gc_product_price::whereIn('price_id', $request->ids)->update([
            'status' => 0
        ]);
    }
    public function enable_item_per_uom(Request $request)
    {
        gc_product_price::whereIn('price_id', $request->ids)->update([
            'status' => 1
        ]);
    }
    public function show_item_enable_per_uom(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');
        $categoryValue = $request->input('category');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_prices', 'gc_product_items.itemcode', '=', 'gc_product_prices.itemcode')
            ->where('gc_product_prices.status', '=', 0)
            ->select('*')
            ->orderBy('price_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_prices.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_prices.UOM', 'like', '%' . $searchValue . '%');
            });
        }

        if ($categoryValue) {
            $query->where(function ($query) use ($categoryValue) {
                $query->where('gc_product_items.category_name', 'like', '%' . $categoryValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function price_count_changed()
    {
        return   DB::table('gc_product_items')
            ->join('gc_product_price_histories', 'gc_product_items.itemcode', '=', 'gc_product_price_histories.itemcode')
            ->whereDate('gc_product_price_histories.update_at', Carbon::today()->toDateString())
            ->select('*')
            ->whereIn('gc_product_items.itemcode', function ($query) {
                $query->select('gc_product_price_histories.itemcode')->from('gc_product_price_histories');
            })
            ->count();
    }

    public function price_count_changed_info(Request $request)
    {

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_product_items')
            ->join('gc_product_price_histories', 'gc_product_items.itemcode', '=', 'gc_product_price_histories.itemcode')
            ->whereDate('gc_product_price_histories.update_at', Carbon::today()->toDateString())
            ->select('*')
            ->whereIn('gc_product_items.itemcode', function ($query) {
                $query->select('gc_product_price_histories.itemcode')->from('gc_product_price_histories');
            })
            ->orderBy('product_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('gc_product_items.itemcode', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_product_items.product_name', 'like', '%' . $searchValue . '%');
            });
        }

        $final_result = $query->paginate($length);

        return  $final_result;
    }

    public function store_available_item(Request $request)
    {
        $store = $request->get('store_id');
        return gc_product_item::with(['item_price'])
            ->where('status', 'active')
            ->whereNotIn('gc_product_items.itemcode', function ($query) use ($store) {
                $query->select('gc_item_log_availables.itemcode')
                    ->from('gc_item_log_availables')
                    ->where('gc_item_log_availables.store', '=', $store);
            })->paginate();
    }

    public function count_per_category()
    {
        return DB::table('gc_product_items')
            ->select('category_no','category_name', DB::raw('COUNT(category_no) as count'))
            ->orderBy('count', 'desc')
            ->groupBy('category_name')
            ->get();
    }
    public function disable_selected_item(Request $request)
    {
        $itemcode = $request->ids;
        $count = 0;
        foreach ($itemcode as $key => $code) {
            $checking =  gc_item_log_available::where('itemcode', $code)->where('store', Auth::user()->bunit_code)->exists();

            if ($checking) {
                $count++;
            } else {
                $data = array(
                    'itemcode'       => $code,
                    'store'          => Auth::user()->bunit_code,
                    'tag_by'         => Auth::user()->name,
                );
                gc_item_log_available::insert($data);
            }
        }
        // return $count;
    }

    public function enable_selected_item(Request $request)
    {
        $itemcode = $request->ids;

        foreach ($itemcode as $key => $code) {
            gc_item_log_available::where('itemcode', $code)->where('store', Auth::user()->bunit_code)->delete();
        }
    }
    public function count_price_changes()
    {
        return DB::table('gc_item_price_changes')
            ->select('*')
            ->join('gc_users', 'gc_item_price_changes.user_id', 'gc_users.id')
            ->where('gc_users.bunit_code', Auth::user()->bunit_code)
            ->whereDate('gc_item_price_changes.created_at', Carbon::today()->toDateString())
            ->count();
    }
}
