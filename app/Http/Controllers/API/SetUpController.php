<?php

namespace App\Http\Controllers\API;

use App\store;
use App\gc_tenant;
use App\Bu_time_setup;
use App\gc_department;
use App\gc_price_group;
use App\gc_delivery_charge;
use Illuminate\Http\Request;
use App\gc_setup_business_rule;
use App\gc_minimum_order_delivery;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SetUpController extends Controller
{

    public function show_rules()
    {
        return gc_setup_business_rule::all();
    }
    public function show_business_time(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('bu_time_setups')
            ->join('locate_business_units', 'bu_time_setups.bunit_code', '=', 'locate_business_units.bunit_code')
            ->select(
                'bu_time_setups.id',
                'locate_business_units.bunit_code',
                'locate_business_units.business_unit',
                'locate_business_units.acroname',
                'bu_time_setups.time_in',
                'bu_time_setups.time_out',
                'bu_time_setups.status',
            )
            ->orderBy('bu_time_setups.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function show_business_time_by_id($id){
      return DB::table('bu_time_setups')
        ->join('locate_business_units', 'bu_time_setups.bunit_code', '=', 'locate_business_units.bunit_code')
        ->select(
            'bu_time_setups.id',
            'locate_business_units.bunit_code',
            'locate_business_units.business_unit',
            'locate_business_units.acroname',
            'bu_time_setups.time_in',
            'bu_time_setups.time_out',
            'bu_time_setups.status',
        )
        ->where('bu_time_setups.id',$id)
        ->get();
    }
    public function save_business_time(Request $request)
    {
        if ($request->id === null) {
            $this->validate($request, [
                'store'        => 'required|unique:bu_time_setups,bunit_code',
                'opening_time'    => 'required',
                'closing_time'      => 'required|after:opening_time',
            ]);
        } else {
            $this->validate($request, [
                'opening_time'    => 'required',
                'closing_time'      => 'required|after:opening_time',
            ]);
        }
        Bu_time_setup::updateOrCreate([
            'id'            => $request->id
        ], [
            'bunit_code'    => $request->store,
            'time_in'       => $request->opening_time,
            'time_out'      => $request->closing_time,
            'status'        => 1
        ]);
    }
    public function delete_business_time($id)
    {
        Bu_time_setup::whereId($id)->delete();
    }

    public function save_tenant(Request $request)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'    => 'required',
        ]);
        $checking_data =  gc_tenant::where('bunit_code', $request->get('store'))
            ->where('dept_id', $request->get('department'))
            ->exists();
        if (!$checking_data) {

            gc_tenant::updateOrCreate([
                'tenant_id'     => $request->id
            ], [
                'bunit_code'    => $request->store,
                'dept_id'       => $request->department,
                'status'        => 1
            ]);
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    }

    public function show_tenant(Request $request)
    {

        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query =  DB::table('gc_tenants')
            ->join('locate_business_units', 'gc_tenants.bunit_code', '=', 'locate_business_units.bunit_code')
            ->join('gc_departments', 'gc_tenants.dept_id', '=', 'gc_departments.dept_id')
            ->select(
                'locate_business_units.business_unit',
                'gc_departments.name',
                'gc_tenants.tenant_id',
                'gc_tenants.status',
                'gc_tenants.bunit_code',
                'gc_tenants.dept_id'
            )
            ->orderBy('gc_tenants.tenant_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }

    public function edit_tenant(Request $request)
    {
        $this->validate($request, [
            'store'        => 'required',
            'department'       => 'required',
        ]);

        gc_tenant::where('tenant_id', $request->id)->update([
            'bunit_code'    => $request->store,
            'dept_id'       => $request->department,
            'status'        => $request->status,
        ]);
    }
    public function delete_tenant($id)
    {
        $tenant = gc_tenant::where('tenant_id', '=', $id);
        $tenant->delete();
    }
    public function business_time_active(Request $request)
    {
        Bu_time_setup::whereId($request->id)->update([
            'status' => 0
        ]);
    }
    public function business_time_inactive(Request $request)
    {
        Bu_time_setup::whereId($request->id)->update([
            'status' => 1
        ]);
    }
    public function business_time_status(Request $request)
    {

        if ($request->status === 1) {
            Bu_time_setup::whereId($request->id)->update([
                'status'    => '0'
            ]);
        } else {
            Bu_time_setup::whereId($request->id)->update([
                'status'    => '1'
            ]);
        }
    }

    public function create_minimum(Request $request)
    {
        $this->validate($request, [
            'store'         => 'required',
            'department'    => 'required',
            'amount'        => 'required',
        ]);

        $checking_data =  gc_minimum_order_delivery::where('bunit_code', $request->store)
            ->where('department_id',     $request->department)
            ->exists();

        if (!$checking_data) {

            gc_minimum_order_delivery::create([
                'bunit_code'    => $request->store,
                'department_id' => $request->department,
                'amount'        => floatval($request->amount)
            ]);
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    } 
    public function show_min_order(Request $request)
    {

        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query =  DB::table('gc_minimum_order_deliveries')
            ->join('locate_business_units', 'gc_minimum_order_deliveries.bunit_code', '=', 'locate_business_units.bunit_code')
            ->join('gc_departments', 'gc_minimum_order_deliveries.department_id', '=', 'gc_departments.dept_id')
            ->select(
                'gc_minimum_order_deliveries.min_id',
                'locate_business_units.business_unit',
                'gc_departments.name',
                'gc_minimum_order_deliveries.bunit_code',
                'gc_minimum_order_deliveries.department_id',
                'gc_minimum_order_deliveries.amount'
            )
            ->orderBy('gc_minimum_order_deliveries.min_id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;

        return $query;
    }
    public function edit_minimum(Request $request)
    {
        $id = $request->id;
        $this->validate($request, [
            'store'         => 'required',
            'department'    => 'required',
            'amount'        => 'required',
        ]);
        gc_minimum_order_delivery::where('min_id', $id)->update([
            'bunit_code'    => $request->store,
            'department_id' => $request->department,
            'amount'        => floatval($request->amount)
        ]);
    }
    public function delete_minimum($id)
    {
        gc_minimum_order_delivery::where('min_id', $id)->delete();
    }

    public function province()
    {
        return  DB::table('province')->get();
    }
    public function town()
    {
        return  DB::table('towns')->get();
    }
    public function barangay()
    {
        return  DB::table('barangays')->get();
    }
    public function transportation()
    {
        return  DB::table('gc_transportations')->get();
    }
    public function store()
    {
        return store::all();
    }
    public function department()
    {
        return gc_department::get();
    }
    public function price_group()
    {
        return gc_price_group::all();
    }

    // public function view_by_id_charges($id)

    public function update_charge(Request $request)
    {

        $chrg_id = $request->id;

        $this->validate($request, [
            'province'          => 'required',
            'town'              => 'required',
            // 'barangay'      => 'required',create_charge
            'transportation'    => 'required',
            'charge_amount'     => 'required',
            'rider_share'       => 'required',
        ]);
        gc_delivery_charge::where('chrg_id', $chrg_id)->update([
            'prov_id'           => $request->province,
            'town_id'           => $request->town,
            'brgy_id'           => $request->barangay,
            'transpo_id'        => $request->transportation,
            'charge_amt'        => floatval($request->charge_amount),
            'rider_shared'      => floatval($request->rider_share),
            'status'            => $request->status
        ]);
    }
    public function show_charge(Request $request)
    {

        $length     = $request->length;
        $dir        = $request->dir;
        $transpo    = $request->transportation;
        $town       = $request->town;
        $province   = $request->province;
        $searchValue     = $request->search;


        $query = gc_delivery_charge::with(['brgy'])
            ->join('province', 'gc_delivery_charges.prov_id', '=', 'province.prov_id')
            ->join('towns', 'gc_delivery_charges.town_id', '=', 'towns.town_id')
            ->join('gc_transportations', 'gc_delivery_charges.transpo_id', '=', 'gc_transportations.id')
            ->select(
                'gc_delivery_charges.chrg_id',
                'gc_delivery_charges.prov_id',
                'gc_delivery_charges.town_id',
                'gc_delivery_charges.brgy_id',
                'gc_delivery_charges.transpo_id',
                'gc_delivery_charges.charge_amt',
                'gc_delivery_charges.rider_shared',
                'gc_delivery_charges.status',
                'province.prov_name',
                'towns.town_name',
                'gc_transportations.transpo_name',
            )
            ->orderBy('gc_delivery_charges.chrg_id', $dir);
        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('province.prov_name',  'like', '%' . $searchValue . '%')
                    ->orWhere('towns.town_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_transportations.transpo_name', 'like', '%' . $searchValue . '%');
            });
        }
        if ($province) {
            $query->where(function ($query) use ($province) {
                $query->where('gc_delivery_charges.prov_id', $province);
            });
        }
        if ($town) {
            $query->where(function ($query) use ($town) {
                $query->where('gc_delivery_charges.town_id', $town);
            });
        }
        if ($transpo) {
            $query->where(function ($query) use ($transpo) {
                $query->where('gc_delivery_charges.transpo_id', $transpo);
            });
        }
        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function create_charge(Request $request)
    {
        $this->validate($request, [
            'province'              => 'required',
            'town'                  => 'required',
            'transportation'        => 'required',
            'charge_amount'         => 'required',
            'rider_share'           => 'required',
        ]);

        if ($request->barangay) {

            $checking_data =  gc_delivery_charge::where('town_id', $request->town)
                ->where('brgy_id',     $request->barangay)
                ->where('transpo_id',  $request->transportation)
                ->exists();
        } else {
            $checking_data =  gc_delivery_charge::where('town_id', $request->town)
                ->where('transpo_id',  $request->transportation)
                ->exists();
        }
        if (!$checking_data) {
            gc_delivery_charge::create([
                'prov_id'           => $request->province,
                'town_id'           => $request->town,
                'brgy_id'           => $request->barangay,
                'transpo_id'        => $request->transportation,
                'charge_amt'        => $request->charge_amount,
                'rider_shared'      => $request->rider_share,
            ]);
        } else {
            return response()->json([
                'errors' => ['message' => ['The system detected double entry! Please try again.']],
            ], 409);
        }
    }
    public function delete_charges($id)
    {
        gc_delivery_charge::where('chrg_id', $id)->delete();
    }
 
    public function show_price_group(Request $request)
    {
        $length = $request->length;
        $dir = $request->dir;
        $searchValue = $request->search;

        $query = DB::table('locate_business_units')
            ->join('gc_price_groups', 'locate_business_units.price_group_code', 'gc_price_groups.price_group_code')
            ->select(
                'locate_business_units.bunit_code',
                'locate_business_units.business_unit',
                'locate_business_units.price_group_code',
                'gc_price_groups.price_group_name',
                'gc_price_groups.id'

            )
            ->where('locate_business_units.active', 1)
            ->orderBy('locate_business_units.bunit_code', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('locate_business_units.business_unit', 'like', '%' . $searchValue . '%')
                    ->orWhere('gc_price_groups.price_group_name', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;
    }
    public function save_store_price_group(Request $request)
    {

        if ($request->id === null) {
            $this->validate($request, [
                'store'        => 'required|unique:locate_business_units,bunit_code',
                'price_group'    => 'required',
            ]);
        } else {
            $this->validate($request, [
                'store'        => 'required',
                'price_group'    => 'required',
            ]);
        }
        DB::table('locate_business_units')->where('locate_business_units.bunit_code', $request->id)->update([
            'price_group_code' => $request->price_group
        ]);
    }
    public function delete_price_group($id)
    {
        DB::table('locate_business_units')->where('locate_business_units.bunit_code', $id)->update([
            'active' => 0
        ]);
    }

    public function rule_update(Request $request)
    {
        $this->validate($request, [
            'minimum_order_amount'      => 'required',
            'pickup_charge'             => 'required',
            'order_time_cutoff_start'   => 'required|',
            'order_time_cutoff_end'     => 'required|after:order_time_cutoff_start',
            'serving_time_start'        => 'required|',
            'serving_time_end'          => 'required|after:serving_time_start',
            'maximum_no_of_order'       => 'required',
        ]);

        gc_setup_business_rule::whereId($request->id)->update([
            'minimum_order_amount'          => $request->minimum_order_amount,
            'pickup_charge'                 => $request->pickup_charge,
            'ordering_cutoff_time_start'    => $request->order_time_cutoff_start,
            'ordering_cutoff_time_end'      => $request->order_time_cutoff_end,
            'serving_time_start'            => $request->serving_time_start,
            'serving_time_end'              => $request->serving_time_end,
            'maximum_no_of_orders'          => $request->maximum_no_of_order,
        ]);
    }
    public function rule_show_by_id($id){
       return gc_setup_business_rule::whereId($id)->first();
    }
}
