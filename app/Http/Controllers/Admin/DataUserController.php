<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IErrorApplication;
use App\Models\User;
use App\Models\UserActivity;
use App\Models\UserFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class DataUserController extends Controller
{
    public function index()
    {
        return view('admin.data-user.index');
    }

    public function data(Request $request)
    {
        $search = request('search.value');
        $data = User::leftJoin('user_foto', 'user_foto.id_user', '=', 'users.id_user')
            ->where('users.delete_mark', '=', 0)->select('users.*', 'user_foto.foto');

        return DataTables::of($data)
            ->filter(function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->orWhere('nama_user', 'LIKE', "%$search%");
                });
            })
            ->editColumn('create_by', function ($row) {
                $createBy = User::where('id_user', $row->create_by)->first();
                return @$createBy['nama_user'];
            })
            ->editColumn('update_by', function ($row) {
                $createBy = User::where('id_user', $row->update_by)->first();
                return @$createBy['nama_user'];
            })
            ->addColumn('foto', function ($row) {
                if ($row->foto != null) {
                    return '<img src="' . asset('/data/user/foto/' . $row->foto) . '" width="100px">';
                } else {
                    return '-';
                }
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
                        <button type="button" class="dropdown-item"
                            data-toggle="modal" data-target="#modal_edit"
                            data-id_user="' . $row->id_user . '"
                            data-nama_user="' . $row->nama_user . '"
                            data-username="' . $row->username . '"
                            data-email="' . $row->email . '"
                            data-no_hp="' . $row->no_hp . '"
                            data-wa="' . $row->wa . '"
                            data-pin="' . $row->pin . '"
                            data-foto="' . $row->foto . '"
                        >Edit</button>
                        <form action="" onsubmit="deleteData(event)" method="POST">
                        ' . method_field('delete') . csrf_field() . '
                            <input type="hidden" name="id_user" value="' . $row->id_user . '">
                            <input type="hidden" name="nama_user" value="' . $row->nama_user . '">
                            <button type="submit" class="dropdown-item text-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>';
                return $actionBtn;
            })
            ->rawColumns(['action', 'foto'])
            ->toJson();
    }

    public function add(Request $request)
    {
        try {
            \DB::beginTransaction();
            $request->validate([
                'nama_user' => 'required',
                'username' => 'required',
                'email' => 'required',
                'no_hp' => 'nullable',
                'wa' => 'nullable',
                'pin' => 'nullable',
            ]);

            $tambah = User::where([
                ['email', $request->email],
            ])->where('delete_mark', '!=', '1')->first();

            if ($tambah) {
                $data = [
                    "message" => 500,
                    "data" => 'Data email sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $user = new User();
            $user->id_user = 1 + User::count();
            $user->nama_user = $request->nama_user;
            $user->username = $request->username;
            $user->password = Hash::make('123456');
            $user->email = $request->email;
            $user->no_hp = $request->no_hp;
            $user->wa = $request->wa;
            $user->pin = $request->pin;
            $user->id_jenis_user = 2;
            $user->status_user = 'aktif';
            $user->create_by = \Auth::user()->id_user;
            $user->update_by = \Auth::user()->id_user;
            $user->save();

            // user id
            $generatedUserId = User::orderBy('id_user', 'desc')->first()->id_user;

            // add foto
            if ($request->has('foto')) {
                $lokasi = 'data/user/foto/';
                $image = $request->file('foto');
                $extensi = $request->file('foto')->extension();
                $new_image_name = 'Foto' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $image->move(public_path($lokasi), $new_image_name);

                $foto = new UserFoto();
                $foto->id_user = $generatedUserId;
                $foto->foto = $new_image_name;
                $foto->create_by = \Auth::user()->id_user;
                $foto->update_by = \Auth::user()->id_user;
                $foto->save();
            }

            //add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Menambah data user dengan nama ' . $request->nama_user;
            $userActivity->status = 'success';
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
                "modules" => 'add user',
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
                'id_user_edit' => 'required',
                'nama_user_edit' => 'required',
                'username_edit' => 'required',
                'email_edit' => 'required',
                'no_hp_edit' => 'nullable',
                'wa_edit' => 'nullable',
                'pin_edit' => 'nullable',
                'password_edit' => 'nullable',
            ]);

            $edit = User::where([
                ['email', $request->email],
            ])->where('id_user', '!=', $request->id_user_edit)->first();

            if ($edit) {
                $data = [
                    "message" => 500,
                    "data" => 'Data email sudah ada',
                    "req" => $request->all(),
                ];
                return $data;
            }

            $user = User::find($request->id_user_edit);
            $user->nama_user = $request->nama_user_edit;
            $user->username = $request->username_edit;
            if ($request->password_edit != null) {
                $user->password = Hash::make($request->password_edit);
            }
            $user->email = $request->email_edit;
            $user->no_hp = $request->no_hp_edit;
            $user->wa = $request->wa_edit;
            $user->pin = $request->pin_edit;
            $user->status_user = 'aktif';
            $user->update_by = \Auth::user()->id_user;
            $user->save();

            $generatedUserId = User::where('id_user', $request->id_user_edit)->first()->id_user;

            $namaFoto = $request->input('fotolama_edit');
            if ($request->has('foto_edit')) {
                $lokasi = 'data/user/foto/';
                $image = $request->file('foto_edit');
                $extensi = $request->file('foto_edit')->extension();
                $new_image_name = 'Foto' . date('YmdHis') . uniqid() . '.' . $extensi;
                $upload = $image->move(public_path($lokasi), $new_image_name);

                $userFoto = UserFoto::where('id_user', $request->id_user_edit)->first();
                if (!$userFoto) {
                    $foto = new UserFoto();
                    $foto->id_user = $generatedUserId;
                    $foto->foto = $new_image_name;
                    $foto->create_by = \Auth::user()->id_user;
                    $foto->update_by = \Auth::user()->id_user;
                    $foto->save();
                } else {
                    $namaFoto = $new_image_name;
                    if ($upload) {
                        $getImage = $userFoto->foto;
                        if ($getImage != null) {
                            File::delete(public_path('data/user/foto/' . $getImage));
                        }
                    }
                    $foto = UserFoto::where('id_user', $generatedUserId)->first();
                    $foto->foto = $namaFoto;
                    $foto->update_by = \Auth::user()->id_user;
                    $foto->save();
                }
            }

            //add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Mengedit data user dengan nama ' . $request->nama_user_edit;
            $userActivity->status = 'success';
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
                "modules" => 'edit user',
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
                'id_user' => 'required',
                'nama_user' => 'nullable',
            ]);

            $deleteUser = User::where('id_user', $request->id_user)->first();
            $deleteUser->delete_mark = 1;
            $deleteUser->save();

            $deleteUserFoto = UserFoto::where('id_user', $request->id_user)->first();
            if ($deleteUserFoto) {
                $getImage = $deleteUserFoto->foto;
                if ($getImage != null) {
                    File::delete(public_path('data/user/foto/' . $getImage));
                }
                $deleteUserFoto->delete_mark = 1;
                $deleteUserFoto->save();
            }

            //add activity
            $userActivity = new UserActivity();
            $userActivity->id_user = \Auth::user()->id_user;
            $userActivity->discripsi = 'Menghapus data user dengan nama ' . $request->nama_user;
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
                "modules" => 'delete user',
                "controller" => $th->getTrace()[0]['file'],
                "function" => $th->getTrace()[0]['function'],
            ];
        }
        return $data;
    }

}