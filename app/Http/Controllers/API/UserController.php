<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\store;
use App\gc_usertype;
use App\gc_employee;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function getusers(Request $request)
    {
        $length = $request->input('length');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query =  DB::table('gc_users')
            ->join('user_types', 'gc_users.usertype_id', '=', 'user_types.id')
            ->join('locate_business_units', 'gc_users.bunit_code', '=', 'locate_business_units.bunit_code')
            ->select(
                'gc_users.id',
                'gc_users.emp_id',
                'gc_users.emp_id',
                'gc_users.bunit_code',
                'gc_users.usertype_id',
                'user_types.usertype',
                'gc_users.name',
                'gc_users.username',
                'locate_business_units.business_unit',
                'gc_users.created_at',
                'gc_users.status',

            )
            ->orderBy('gc_users.id', $dir);

        if ($searchValue) {
            $query->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('business_unit', 'like', '%' . $searchValue . '%');
            });
        }

        $finalResults = $query->paginate($length);

        return $finalResults;

        // return $query;
    }
    public function usertype()
    {
        return gc_usertype::where('type', '=', 2)->orwhere('type', '=', 0)->get();
    }
    public function getStores()
    {
        return store::all();
    }
    public function delete_user($id)
    {
        User::whereId($id)->delete();
    }
    public function create_user(Request $request)
    {

        $this->validate($request, [
            'name'          => ['required', 'string', 'max:255'],
            'username'      => ['required', 'string', 'string', 'max:255', 'unique:users,username'],
            'usertype'      => ['required'],
            'store'         => ['required'],
        ]);

        $default_password = 'alturush2020';

        if ($request->get('password')) {
            if (
                $request->usertype == 6  ||
                $request->usertype == 12 ||
                $request->usertype == 15 ||
                $request->usertype == 7  ||
                $request->usertype == 14 ||
                $request->usertype == 8  
            ) {

                $user_add_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'password'          => Hash::make($request->password),
                    'password2'         => md5($request->password),
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        => $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => true,
                    'status'           => true,

                );
            } else {
                $user_add_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'password'          => Hash::make($request->password),
                    'password2'         => md5($request->password),
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        =>  $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => false,
                    'status'           => true,
                );
            }
        } else {
            if (
                $request->usertype == 6  ||
                $request->usertype == 12 ||
                $request->usertype == 15 ||
                $request->usertype == 7  ||
                $request->usertype == 14 ||
                $request->usertype == 8  
            ) {

                $user_add_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'password'          => Hash::make($default_password),
                    'password2'         => md5($default_password),
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        =>  $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => true,
                    'status'           => true,

                );
            } else {
                $user_add_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'password'          => Hash::make($default_password),
                    'password2'         => md5($default_password),
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        => $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => false,
                    'status'           => true,

                );
            }
        }
        User::insert($user_add_data);

    }

    public function update_user(Request $request)
    {

        $this->validate($request, [
            'name'          => 'required',
            'username'      => 'required',
            'usertype'      => 'required',
            'store'         => 'required',
        ]);

        if (
            $request->usertype == 6  ||
            $request->usertype == 12 ||
            $request->usertype == 15 ||
            $request->usertype == 7  ||
            $request->usertype == 14 ||
            $request->usertype == 8  
        ) {

            if ($request->password != "") {

                $user_edit_data = array(
                    'name'               => $request->name,
                    'username'           => $request->username,
                    'password'           => Hash::make($request->password),
                    'password2'          => md5($request->password),
                    'usertype_id'        => $request->usertype,
                    'bunit_code'         => $request->store,
                    'emp_id'             => $request->emp_id,
                    'isAdmin'            => true
                );
            } else {

                $user_edit_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        => $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => true,

                );
            }
        } else {

            if ($request->get('password') != "") {

                $user_edit_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'password'          => Hash::make($request->password),
                    'password2'         => md5($request->password),
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        => $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => false
                );
            } else {
                $user_edit_data = array(
                    'name'              => $request->name,
                    'username'          => $request->username,
                    'usertype_id'       => $request->usertype,
                    'bunit_code'        => $request->store,
                    'emp_id'            => $request->emp_id,
                    'isAdmin'           => false
                );
            }
        }

        User::where('id', $request->id )->update($user_edit_data);
    
    }
    public function employees(Request $request)
    {
        if ($request->employee) {
            return gc_employee::where('name', 'like', '%' . $request->employee . '%')->get();
        }
    }

    public function updateprofile(Request $request)
    {

        if ($request->get('username')) {
            $user_profile = array(
                'username'  => $request->get('username'),
            );
        }
        if ($request->get('password')) {
            $user_profile = array(
                'password'  => Hash::make($request->get('password')),
                'password2'  => md5($request->get('password')),
            );
        }
        if ($request->get('username') && $request->get('password')) {
            $user_profile = array(
                'username'  => $request->get('username'),
                'password'  => Hash::make($request->get('password')),
                'password2'  => md5($request->get('password')),
            );
        }
        User::where('id', '=', Auth::user()->id)->update($user_profile);
    }
    public function active_user(Request $request){
       User::whereId($request->id)->update([
           'status' => 0
       ]);
    }
    public function inactive_user(Request $request){
        User::whereId($request->id)->update([
            'status' => 1
        ]);
    }
}
