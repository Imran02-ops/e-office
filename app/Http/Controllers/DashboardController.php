<?php

namespace App\Http\Controllers;

use App\Models\Berkas;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBerkas = Berkas::count();
        $totalSelesai = Berkas::where('status', 'selesai')->count();
        $totalDikerjakan = Berkas::where('status', 'dikerjakan')->count();

        return view('dashboard', compact(
            'totalBerkas',
            'totalSelesai',
            'totalDikerjakan'
        ));
    }
}
