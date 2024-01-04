<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pegawai;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = pegawai::orderBy('nama','asc');
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('aksi',function($data){
            return view('pegawai.tombol')->with('data',$data);
        })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = Validator::make($request->all(), [
            'nama'=>'required',
            'email'=>'required|email',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'email.required'=>'Email wajib diisi',
            'email.email'=>'Format email harus benar',
        ]);
        if($validasi->fails()){
            return response()->json(['errors'=> $validasi->errors()]);
        }else{
            $data = [
                'nama'=>$request->nama,
                'email'=>$request->email
            ];
            pegawai::create($data);
            return response()->json(['success'=>'Data Berhasil ditambahkan']);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = pegawai::where('id',$id)->first();
        return response()->json(['result'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validasi = Validator::make($request->all(), [
            'nama'=>'required',
            'email'=>'required|email',
        ],[
            'nama.required'=>'Nama wajib diisi',
            'email.required'=>'Email wajib diisi',
            'email.email'=>'Format email harus benar',
        ]);
        if($validasi->fails()){
            return response()->json(['errors'=> $validasi->errors()]);
        }else{
            $data = [
                'nama'=>$request->nama,
                'email'=>$request->email
            ];
            pegawai::where('id',$id)->update($data);
            return response()->json(['success'=>'Data Berhasil diubah']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        pegawai::where('id',$id)->delete();
    }
}
