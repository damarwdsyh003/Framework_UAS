<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\models\Minuman;
use Carbon\Carbon;
use DB;

class MinumanC extends Controller
{
    public function index()
    {
        $minumans = DB::table('minuman')->get();
        return view('minuman',compact('minumans'));
    }

    public function create()
    {
        return view('minuman-tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_minuman'      => 'required',
            'harga_minuman'     => 'required',
        ]);

        $save = new Minuman;
        $save->nama_minuman = $request->nama_minuman;
        $save->tgl_daftar   = Carbon::now();
        $save->harga_minuman= $request->harga_minuman;
        

        $save->save();

        if ($save) {
            return redirect('/minuman');
        }
        
        return redirect()->back()->with('pesan', 'Gagal menambahkan minuman');
    }

    public function edit($id)
    {
        $minumans=Minuman::find($id);
        return view('minuman-edit', compact('minumans'));
    }

    public function update(Request $request, $id)
    {
        $validator=Validator::make($request->all(), [
            'nama_minuman'      => 'required',
            'harga_minuman'     => 'required',
        ]);
        if ($validator->fails()) {
            return Response()->json($validator->errors());
        }

        $update = Minuman::find($id);

        $update->nama_minuman       = $request->nama_minuman;
        $update->harga_minuman      = $request->harga_minuman;

        $update->update();
        return redirect('/minuman');
    }

    public function destroy($id)
    {
        $data = Minuman::find($id)->delete();
        return redirect('/minuman');
    }
}
