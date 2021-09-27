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
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function get_users(Request $request)
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
                'gc_users.inactivity_date',

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
    public function delete_user($id)
    {
        User::whereId($id)->delete();
    }
    public function create_user(Request $request)
    {

        if ($request->password) {
            $this->validate($request, [
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'string', 'max:255', 'unique:gc_users,username'],
                'emp_id'        => ['required'],
                'usertype'      => ['required'],
                'store'         => ['required'],
                'store'         => ['required'],
                'password'      => ['required', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/']
            ]);
        } else {
            $this->validate($request, [
                'name'          => ['required', 'string', 'max:255'],
                'username'      => ['required', 'string', 'string', 'max:255', 'unique:gc_users,username'],
                'emp_id'        => ['required'],
                'usertype'      => ['required'],
                'store'         => ['required'],
            ]);
        }


        $default_password = '@ltur4s2020';

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
        User::where('id', $request->id)->update($user_edit_data);
    }
    public function employees(Request $request)
    {
        if ($request->employee) {
            return gc_employee::where('name', 'like', '%' . $request->employee . '%')->get();
        }
    }
    public function change_password(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required|min:8|different:old_password|confirmed',
        ]);
        if (Hash::check($request->old_password, $user->password)) {
            $user->fill([
                'password' => Hash::make($request->new_password),
                'password2' => md5($request->new_password)
            ])->save();
        } else {

            $custom_error = array(
                'old_password' => ['Password does not match']
            );
            return response()->json([
                'errors' => $custom_error,
            ], 422);
        }
    }
    public function change_username(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $this->validate($request, [
            'old_username' => 'required',
            'new_username' => 'required|different:old_username|unique:gc_users,username',
        ]);

        if ($request->old_username === $user->username) {
            $user->fill([
                'username' => $request->new_username,
            ])->save();
        } else {

            $custom_error = array(
                'old_username' => ['Username does not match']
            );
            return response()->json([
                'errors' => $custom_error,
            ], 422);
        }
    }
    public function profile_image(Request $request)
    {
        $this->validate($request, [
            'profile_image'      => 'required|image|mimes:jpg,png,jpeg',
        ]);

        $userImage = $request->file('profile_image');
        $imageName = Auth::user()->username . '.' . $userImage->getClientOriginalExtension();

        $path = public_path() . '/USER-PROFILE/';

        // $path = '../admins.alturush.com/USER-PROFILE/';\
        $userImage->move($path, $imageName);

        if (file_exists($path)) {
            @unlink($path);
        }

        User::whereId(Auth::user()->id)->update([
            'image' => $imageName
        ]);
    }
    public function user_status(Request $request)
    {
        if ($request->status === 1) {
            User::whereId($request->id)->update([
                'status' => 0,
                'inactivity_date' => date('Y-m-d H:i:s')
            ]);
        } else {
            User::whereId($request->id)->update([
                'status' => 1,
                'inactivity_date' => null
            ]);
        }
    }
}
