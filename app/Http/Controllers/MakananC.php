<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\models\Makanan;
use Carbon\Carbon;
use DB;

class MakananC extends Controller
{
    public function index()
    {
        $makanans = DB::table('makanan')->get();
        return view('makanan',compact('makanans'));
    }

    public function create()
    {
        return view('makanan-tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan'      => 'required',
            'harga_makanan'     => 'required',
        ]);

        $save = new Makanan;
        $save->nama_makanan = $request->nama_makanan;
        $save->tgl_daftar = Carbon::now();
        $save->harga_makanan = $request->harga_makanan;
        

        $save->save();

        if ($save) {
            return redirect('/makanan');
        }
        
        return redirect()->back()->with('pesan', 'Gagal menambahkan makanan');
    }

    public function edit($id)
    {
        $makanans=Makanan::find($id);
        return view('makanan-edit', compact('makanans'));
    }

    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(), [
            'nama_makanan'      => 'required',
            'harga_makanan'     => 'required',
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $update = Makanan::find($id);

        $update->nama_makanan       = $request->nama_makanan;
        $update->harga_makanan      = $request->harga_makanan;

        $update->update();
        return redirect('/makanan');
    }

    public function destroy($id)
    {
        $data = Makanan::find($id)->delete();
        return redirect('/makanan');
    }
}
