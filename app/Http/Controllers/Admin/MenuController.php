<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuLevel;
use App\Models\MenuUser;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        $level = MenuLevel::all();
        $menu = Menu::where('parent_id', null)->get();
        return view('admin.menu.index', compact('level', 'menu'));
    }

    public function data()
    {
        $search = request('search.value');
        $data = Menu::join('menu_level', 'menu_level.id_level', '=', 'menu.id_level')
            ->where('menu.delete_mark', '=', 0)->select('menu.*', 'menu_level.level as level');

        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('menu_name', 'LIKE', "%$search%");
                });
            })
            ->editColumn('menu_icon', function ($row) {
                return "<i class='fa $row->menu_icon'></i>";
            })
            ->editColumn('create_by', function ($row) {
                $createBy = User::where('id_user', $row->create_by)->first();
                return @$createBy['nama_user'];
            })
            ->editColumn('update_by', function ($row) {
                $createBy = User::where('id_user', $row->update_by)->first();
                return @$createBy['nama_user'];
            })
            ->addColumn('level', function ($row) {
                return $row->level;
            })
            ->editColumn('parent_id', function ($row) {
                $parentId = Menu::find($row->parent_id);
                return $parentId == null ? '-' : $parentId->menu_name;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Klik
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="' . route('admin.menu.akses-menu-user', ['idMenu' => $row->menu_id]) . '">Akses User</a>
                        <button type="button" class="dropdown-item"
                            data-toggle="modal" data-target="#modal_edit"
                            data-menu_id="' . $row->menu_id . '"
                            data-id_level="' . $row->id_level . '"
                            data-menu_name="' . $row->menu_name . '"
                            data-menu_link="' . $row->menu_link . '"
                            data-menu_icon="' . $row->menu_icon . '"
                            data-parent_id="' . $row->parent_id . '"
                        >Edit</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="menu_id" value="' . $row->menu_id . '">
                            <input type="hidden" name="menu_name" value="' . $row->menu_name . '">
                            <button type="submit" class="dropdown-item text-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'level', 'menu_icon'])
            ->toJson();
    }

    public function add(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'id_level' => 'required',
                'menu_name' => 'required',
                'menu_link' => 'required',
                'menu_icon' => 'nullable',
                'parent_id' => 'nullable',
            ]);

            $tambah = Menu::where([
                ['menu_name', $request->menu_name],
            ])->where('delete_mark', '!=', '1')->first();

            if ($tambah) {
                $data = [
                    "message" => 500,
                    "data" => 'Data Menu sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $menu = new Menu();
            $menu->menu_id = 1 + Menu::count();
            $menu->id_level = $request->id_level;
            $menu->menu_name = $request->menu_name;
            $menu->menu_link = $request->menu_link;
            $menu->menu_icon = $request->menu_icon;
            $menu->parent_id = $request->parent_id;
            $menu->create_by = \Auth::user()->id_user;
            $menu->create_date = date('Y-m-d');
            $menu->update_by = \Auth::user()->id_user;
            $menu->update_date = date('Y-m-d');
            $menu->save();

            $generatedMenuId = Menu::orderBy('menu_id', 'desc')->first()->menu_id;

            // add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Menambah data menu dengan nama ' . $request->menu_name;
            $userActivity->status = 'success';
            $userActivity->menu_id = $generatedMenuId;
            $userActivity->create_by = \Auth::user()->id_user;
            $userActivity->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan data',
                "req" => $request->all(),
            ];

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();

            $data = [
                "message" => 500,
                "data" => "Gagal menambahkan data",
                "req" => $request->all(),
                "error_message" => $th->getMessage(),
                "error_line" => $th->getLine(),
                "modules" => 'add menu',
                "controller" => $th->getTrace()[0]['file'],
                "function" => $th->getTrace()[0]['function'],
            ];
        }
        return $data;
    }

    public function edit(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'menu_id_edit' => 'required',
                'id_level_edit' => 'required',
                'menu_name_edit' => 'required',
                'menu_link_edit' => 'required',
                'menu_icon_edit' => 'nullable',
                'parent_id_edit' => 'nullable',
            ]);

            $tambah = Menu::where([
                ['menu_name', $request->menu_name],
            ])->where('menu_id', '!=', $request->menu_id_edit)->first();

            if ($tambah) {
                $data = [
                    "message" => 500,
                    "data" => 'Data Menu sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $menu = Menu::find($request->menu_id_edit);
            $menu->id_level = $request->id_level_edit;
            $menu->menu_name = $request->menu_name_edit;
            $menu->menu_link = $request->menu_link_edit;
            $menu->menu_icon = $request->menu_icon_edit;
            $menu->parent_id = $request->parent_id_edit;
            $menu->update_by = \Auth::user()->id_user;
            $menu->update_date = date('Y-m-d');
            $menu->save();

            // add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Mengedit data menu dengan nama ' . $request->menu_name_edit;
            $userActivity->status = 'success';
            $userActivity->menu_id = $request->menu_id_edit;
            $userActivity->create_by = \Auth::user()->id_user;
            $userActivity->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil mengedit data',
                "req" => $request->all(),
            ];

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();

            $data = [
                "message" => 500,
                "data" => "Gagal mengedit data",
                "req" => $request->all(),
                "error_message" => $th->getMessage(),
                "error_line" => $th->getLine(),
                "modules" => 'edit menu',
                "controller" => $th->getTrace()[0]['file'],
                "function" => $th->getTrace()[0]['function'],
            ];
        }
        return $data;
    }

    public function delete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'menu_id' => 'required',
                'menu_name' => 'nullable',
            ]);

            $deleteUser = Menu::where('menu_id', $request->menu_id)->first();
            $deleteUser->delete_mark = 1;
            $deleteUser->save();

            //add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Menghapus data menu dengan nama ' . $request->menu_name;
            $userActivity->status = 'success';
            $userActivity->create_by = \Auth::user()->id_user;
            $userActivity->save();

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data",
            ];

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            $data = [
                "message" => 500,
                "data" => "Gagal menghapus data",
                "req" => $request->all(),
                "error_message" => $th->getMessage(),
                "error_line" => $th->getLine(),
                "modules" => 'delete menu',
                "controller" => $th->getTrace()[0]['file'],
                "function" => $th->getTrace()[0]['function'],
            ];
        }
        return $data;
    }

    public function aksesMenuUser($idMenu)
    {
        $menu = Menu::find($idMenu);
        $user = User::where('delete_mark', '!=', '1')->get();
        return view('admin.menu.menu-user.index', compact('menu', 'user'));
    }

    public function aksesMenuUserData(Request $request)
    {
        $search = request('search.value');
        $menuId = $request->input('menu_id');
        $data = MenuUser::join('users as user', 'user.id_user', '=', 'menu_user.id_user')
            ->join('menu', 'menu.menu_id', '=', 'menu_user.menu_id')
            ->where('menu_user.menu_id', '=', $menuId)
            ->where('menu_user.delete_mark', '=', 0)->select('menu_user.*', 'user.nama_user as nama_user', 'menu.menu_id as menu_id', 'menu.menu_name as menu_name');

        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama_user', 'LIKE', "%$search%");
                });
            })
            ->editColumn('update_by', function ($row) {
                $createBy = User::where('id_user', $row->update_by)->first();
                return @$createBy['nama_user'];
            })
            ->addColumn('user', function ($row) {
                return $row->nama_user;
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        Klik
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="no_setting" value="' . $row->no_setting . '">
                            <input type="hidden" name="nama_user" value="' . $row->nama_user . '">
                            <input type="hidden" name="menu_name" value="' . $row->menu_name . '">
                            <input type="hidden" name="menu_id" value="' . $row->menu_id . '">
                            <button type="submit" class="dropdown-item text-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'user'])
            ->toJson();
    }

    public function aksesMenuUserAdd(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'id_user' => 'required',
                'menu_id' => 'required',
            ]);

            $tambah = MenuUser::where([
                ['id_user', $request->id_user],
            ])->where('menu_id', $request->menu_id)->where('delete_mark', '!=', '1')->first();

            if ($tambah) {
                $data = [
                    "message" => 500,
                    "data" => 'Akses User ini sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $menu = new MenuUser();
            $menu->id_user = $request->id_user;
            $menu->menu_id = $request->menu_id;
            $menu->create_date = date('Y-m-d');
            $menu->update_by = \Auth::user()->id_user;
            $menu->save();

            $generatedMenu = Menu::where('menu_id', $request->menu_id)->first();
            $generatedUserNama = User::where('id_user', $request->id_user)->first()->nama_user;

            // add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Menambah akses ' . $generatedUserNama . ' untuk menu ' . $generatedMenu->menu_name;
            $userActivity->status = 'success';
            $userActivity->menu_id = $generatedMenu->menu_id;
            $userActivity->create_by = \Auth::user()->id_user;
            $userActivity->save();

            $data = [
                "message" => 200,
                "data" => 'Berhasil menambahkan data',
                "req" => $request->all(),
            ];

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();

            $data = [
                "message" => 500,
                "data" => "Gagal menambahkan data",
                "req" => $request->all(),
                "error_message" => $th->getMessage(),
                "error_line" => $th->getLine(),
                "modules" => 'add user access menu',
                "controller" => $th->getTrace()[0]['file'],
                "function" => $th->getTrace()[0]['function'],
            ];
        }
        return $data;
    }

    public function aksesMenuUserDelete(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'no_setting' => 'required',
                'nama_user' => 'required',
                'menu_name' => 'required',
                'menu_id' => 'required',
            ]);

            $deleteUser = MenuUser::where('no_setting', $request->no_setting)->first();
            $deleteUser->delete_mark = 1;
            $deleteUser->save();

            //add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Menghapus akses ' . $request->nama_user . ' dari menu ' . $request->menu_name;
            $userActivity->status = 'success';
            $userActivity->menu_id = $request->menu_id;
            $userActivity->create_by = \Auth::user()->id_user;
            $userActivity->save();

            $data = [
                "message" => 200,
                "data" => "Berhasil menghapus data",
            ];

            \DB::commit();
        } catch (\Throwable $th) {
            \DB::rollBack();
            $data = [
                "message" => 500,
                "data" => "Gagal menghapus data",
                "req" => $request->all(),
                "error_message" => $th->getMessage(),
                "error_line" => $th->getLine(),
                "modules" => 'delete akses menu user',
                "controller" => $th->getTrace()[0]['file'],
                "function" => $th->getTrace()[0]['function'],
            ];
        }
        return $data;
    }
}