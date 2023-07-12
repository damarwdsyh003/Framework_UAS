<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\Makanan;
use App\Models\Minuman;
use DB;

class TenantC extends Controller
{
    public function index()
    {
        $tenants=Tenant::all();
        return view('tenant', compact('tenants'));
    }

    public function create()
    {
        $datamakanan = DB::table('makanan')
                          ->select('*')
                          ->get();
        
        
        return view('/tenant-tambah', compact('datamakanan'));

        $dataminuman = DB::table('minuman')
                          ->select('*')
                          ->get();


        return view('/tenant-tambah', compact('dataminuman'));
    }

    public function store(Request $request)
    {

        $cek = DB::table('tenant')
                 ->where('tenant.id_makanan',$request->id_makanan)
                 ->where('tenant.id_minuman',$request->id_minuman)
                 ->join('makanan','tenant.id_makanan','=','makanan.id_makanan')
                 ->join('minuman','tenant.id_minuman','=','minuman.id_minuman')
                 ->get();
        $cek2=count($cek);
        
        if($cek2 == 1){
        return response()->json(['status'=>'gagal']);

        }else{
            $save = new Tenant;

            $save->id_makanan = $request->id_makanan;
            $save->id_minuman = $request->id_minuman;
    
            $save->save();
        
            return redirect('/tenant');
        }
    }

    public function show($id)
    {
        $tenant = Tenant::find($id);
        return response()->json(['data'=>$tenant]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        // 
    }

    public function destroy($id)
    {
        $data = Tenant::find($id);
        $data->delete();

        if ($data) {
            return response()->json(['status'=>'Data berhasil dihapus']);
        } else {
            return response()->json(['status'=>'Data gagal dihapus']);
        }
    }
}
