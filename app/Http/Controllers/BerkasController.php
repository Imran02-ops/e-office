<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berkas;

class BerkasController extends Controller
{
    public function index()
    {
        $berkas = Berkas::latest()->get();
        return view('berkas.index', compact('berkas'));
    }

    public function create()
    {
        return view('berkas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_berkas' => 'required',
            'file' => 'required|file'
        ]);

        $filePath = $request->file('file')->store('berkas', 'public');

        Berkas::create([
            'nama_berkas' => $request->nama_berkas,
            'file_path' => $filePath,
            'status' => 'dikerjakan'
        ]);

        return redirect()->route('berkas.index')
            ->with('success', 'Berkas berhasil diupload');
    }
}
