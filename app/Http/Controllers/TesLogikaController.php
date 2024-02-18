<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesLogikaController extends Controller
{
    public function logika1(Request $request)
    {
        $angka = 0;
        if ($request->has('angka')) {
            $angka = $request->angka;
        }

        return view('logika1', compact('angka'));
    }
    public function logika2(Request $request)
    {
        $angka = null;
        if ($request->has('angka')) {
            $angka = $request->angka;
        }

        return view('logika2', compact('angka'));
    }

    public function erdKepegawaian()
    {
        return view('erd-kepegawaian');
    }
}