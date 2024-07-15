<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Index()
    {
        return view('Auth.index');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->status == 1) {
                return redirect()->intended('dashboard');
            }
        }
        return back()->with('loginError', 'Login gagal !');
    }
    public function Infoakun()
    {
        $menu = "infoakun";
        $data = db::select('select a.nama,a.username,a.hak_akses,b.nama_unit from user a left join mt_unit b on a.unit = b.kode_unit where a.id = ?',[auth()->user()->id]);
        return view('Auth.infoakun',compact([
            'menu','data'
        ]));
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
