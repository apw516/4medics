<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function Index()
    {
        return view('Auth.index');
    }
    public function register()
    {
        $unit = db::select('select * from mt_unit');
        return view('Auth.register',compact([
            'unit'
        ]));
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
    public function post(Request $request)
    {
        $validateData = $request ->validate([
           'namalengkap' => 'required|max:255',
           'username' => ['required','min:3','max:255','unique:user'],
           'hakakses' =>'required',
           'unit' =>'required',
           'password' => 'required|min:5|max:255|same:password2'
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        $validateData['tanggal_entry'] = $this->get_now();
        $datauser = [
            'username' => $validateData['username'],
            'nama' => $validateData['namalengkap'],
            'password' => $validateData['password'],
            'hak_akses' => $validateData['hakakses'],
            'unit' => $validateData['unit'],
            'tgl_entry' => $validateData['tanggal_entry'],
        ];
        User::create($datauser);
        // $request->session()->flash('success','Registration successful, Please Login');
        return redirect('/')->with('success','Registration successful, Please Login');
    }
    public function Infoakun()
    {
        $menu = "infoakun";
        $data = db::select('select a.nama,a.username,a.hak_akses,b.nama_unit from user a left join mt_unit b on a.unit = b.kode_unit where a.id = ?',[auth()->user()->id]);
        return view('Auth.infoakun',compact([
            'menu','data'
        ]));
    }
    public function get_time()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        return $time;
    }
    public function get_now()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $time = $dt->toTimeString();
        $now = $date . ' ' . $time;
        return $now;
    }
    public function get_date()
    {
        $dt = Carbon::now()->timezone('Asia/Jakarta');
        $date = $dt->toDateString();
        $now = $date;
        return $now;
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
