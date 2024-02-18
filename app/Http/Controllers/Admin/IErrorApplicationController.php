<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IErrorApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class IErrorApplicationController extends Controller
{
    public function index()
    {
        return view('admin.i_error_application.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = IErrorApplication::leftJoin('users', 'users.id_user', '=', 'i_error_application.id_user')
            ->where('i_error_application.delete_mark', '=', 0)->select('i_error_application.*', 'users.nama_user as nama_user');

        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('users.nama_user', 'LIKE', "%$search%");
                });
            })
            ->editColumn('update_by', function ($row) {
                $updateBy = User::where('id_user', $row->update_by)->first();
                return @$updateBy['nama_user'];
            })
            ->addColumn('nama_user', function ($row) {
                return $row->nama_user;
            })
            ->rawColumns(['nama_user'])
            ->toJson();
    }

    public function add(Request $request)
    {
        $error = new IErrorApplication();
        $error->id_user = \Auth::user()->id_user;
        $error->error_date = date('d');
        $error->modules = $request->modules;
        $error->controller = $request->controller;
        $error->function = $request->function;
        $error->error_line = $request->error_line;
        $error->error_message = $request->error_message;
        $error->status = 'error';
        $error->param = '';
        $error->create_date = now();
        $error->update_by = \Auth::user()->id_user;
        $error->save();

        return response()->json($error);

    }
}