<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserActivityController extends Controller
{
    public function index()
    {
        return view('admin.user-activity.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = UserActivity::leftJoin('users', 'users.id_user', '=', 'user_activity.id_user')
            ->where('user_activity.delete_mark', '=', 0)->select('user_activity.*', 'users.nama_user as nama_user');

        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('users.nama_user', 'LIKE', "%$search%");
                });
            })
            ->editColumn('create_by', function ($row) {
                $createBy = User::where('id_user', $row->create_by)->first();
                return @$createBy['nama_user'];
            })
            ->addColumn('nama_user', function ($row) {
                return $row->nama_user;
            })
            ->rawColumns(['nama_user'])
            ->toJson();
    }
}