<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Auth;
use DB;
use Alert;

class UsersC extends Controller
{
    public function login(Request $req)
    {
        // dd($req->all());
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard')->with('message', 'Berhasil Login');
        }

        return redirect()->back()->with('alert', 'Email atau password salah!');
    }

    public function login1(Request $req)
    {
        $credentials = $req->only('email', 'password');

        try{
            if(! $token = JWTAuth::attempt($credentials)){
                return response()->json(['error'=>'invalid_credentials'], 400);
                return response()->json(['error'=>'Username atau Password anda salah']);
            }
        }catch (JWTException $e){
            return response()->json(['error'=>'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));

    }

    //register role civitas_akademik
    public function register1(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->no_hp = $req->no_hp;
        $user->email = $req->email;
        $user->password = Hash::make($req->get('password'));
        $user->role = 'civitas_akademik';
        $user->save();

        $token = JWTAuth::fromUser($user);

        if ($user) {
            return redirect('/');
        } else {
            return redirect()->back()->with('message-simpan', 'Gagal membuat akun, masukkan data dengan lengkap!');
        }
    }

    //register role pelanggan
    public function register2(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->no_hp = $req->no_hp;
        $user->email = $req->email;
        $user->password = Hash::make($req->get('password'));
        $user->role = 'pelanggan';
        $user->save();

        $token = JWTAuth::fromUser($user);

        if ($user) {
            return redirect('/');
        } else {
            return redirect()->back()->with('message-simpan', 'Gagal membuat akun, masukkan data dengan lengkap!');
        }
    }

    //register role staf
    public function register3(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->no_hp = $req->no_hp;
        $user->email = $req->email;
        $user->password = Hash::make($req->get('password'));
        $user->role = 'staf';
        $user->save();

        $token = JWTAuth::fromUser($user);

        if ($user) {
            return redirect('/');
        } else {
            return redirect()->back()->with('message-simpan', 'Gagal membuat akun, masukkan data dengan lengkap!');
        }
    }

    //register role admin
    public function register4(Request $req)
    {

        $req->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'required|min:11',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = new User;
        $user->nama = $req->nama;
        $user->no_hp = $req->no_hp;
        $user->email = $req->email;
        $user->password = Hash::make($req->get('password'));
        $user->role = 'admin';
        $user->save();

        $token = JWTAuth::fromUser($user);

        if ($user) {
            return redirect('/');
        } else {
            return redirect()->back()->with('message-simpan', 'Gagal membuat akun, masukkan data dengan lengkap!');
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }

    public function getprofile()
    {
    	return response()->json(['data'=>JWTAuth::user()]);
    }
    
    public function getprofileadmin()
    {
        return response()->json(['data'=>JWTAuth::user()]);
    }

    public function logout(Request $req)
    {
        Auth::logout();
        return view('login');
    }

    // Admin
    public function showadmin()
    {
        $admins = User::all()->where('role', 'admin');
        return view('admin', compact('admins'));
    }

    public function showeditadmin($id)
    {
        $admins1 = User::find($id);

        return view('/admin-edit', compact('admins1'));
    }

    public function editadmin(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'email'     => 'required',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->email      = $req->email;
        $update->update();

        $admins = User::all()->where('role', 'admin');
        
        return redirect('/admin');
    }

    public function hapusadmin($id)
    {
        $destroy=User::find($id)->delete();
        $admins = User::all()->where('role', 'admin');
        return view('admin', compact('admins'));
    }

    // Staf
    public function showstaf()
    {
        $staf = User::all()->where('role', 'staf');
        return view('staf', compact('staf'));
    }

    public function showeditstaf($id)
    {
        $staf1 = User::find($id);

        return view('/staf-edit', compact('staf1'));
    }

    public function editstaf(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'email'     => 'required',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->email      = $req->email;
        $update->update();

        $staf = User::all()->where('role', 'staf');
        return redirect('/staf');
    }

    public function hapusstaf($id)
    {
        $destroy=User::find($id)->delete();
        $staf = User::all()->where('role', 'staf');
        return view('staf', compact('staf'));
    }

    // Civitas Akademik
    public function showcivitas_akademik()
    {
        $civitas_akademik = User::all()->where('role', 'civitas_akademik');
        return view('civitas_akademik', compact('civitas_akademik'));
    }

    public function showeditcivitas_akademik($id)
    {
        $civitas_akademik1 = User::find($id);

        return view('/civitas_akademik-edit', compact('civitas_akademik1'));
    }

    public function editcivitas_akademik(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'email'     => 'email',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->email      = $req->email;
        $update->update();

        $civitas_akademik = User::all()->where('role', 'civitas_akademik');
        return redirect('/civitas_akademik');
    }

    public function hapuscivitas_akademik($id)
    {
        $destroy=User::find($id)->delete();
        $civitas_akademik = User::all()->where('role', 'civitas_akademik');
        return view('civitas_akademik', compact('civitas_akademik'));
    }

    // Pelanggan
    public function showpelanggan()
    {
        $pelanggan = User::all()->where('role', 'pelanggan');
        return view('pelanggan', compact('pelanggan'));
    }

    public function showeditpelanggan($id)
    {
        $pelanggan1 = User::find($id);

        return view('/pelanggan-edit', compact('pelanggan1'));
    }

    public function editpelanggan(Request $req, $id)
    {
        $req->validate([
            'nama'      => 'required',
            'no_hp'     => 'required',
            'email'     => 'email',
        ]);

        $update=User::find($id);
        $update->nama       = $req->nama;
        $update->no_hp      = $req->no_hp;
        $update->email      = $req->email;
        $update->update();

        $pelanggan = User::all()->where('role', 'pelanggan');
        return redirect('/pelanggan');
    }

    public function hapuspelanggan($id)
    {
        $destroy=User::find($id)->delete();
        $pelanggan = User::all()->where('role', 'pelanggan');
        return view('pelanggan', compact('pelanggan'));
    }

    // Halaman Login
    public function halamanlogin(){
        return view ('login');
    }
}
