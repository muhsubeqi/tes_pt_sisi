<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuUser;
use Illuminate\Http\Request;

class DataMenuController extends Controller
{
    public function index($menu)
    {
        $menu = Menu::where('menu_link', $menu)->firstOrFail();

        $cekAkses = MenuUser::join('menu', 'menu.menu_id', '=', 'menu_user.menu_id')
            ->join('users', 'users.id_user', '=', 'menu_user.id_user')
            ->where('users.id_user', \Auth::user()->id_user)
            ->where('menu_user.delete_mark', 0)
            ->first();

        if (!$cekAkses) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini');
        }

        return view('admin.data-menu.index', compact('menu'));
    }
}