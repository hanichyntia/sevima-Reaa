<?php
namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function createKelas(Request $request)
    {
        // 1. Validasi input (hanya butuh nama_kelas)
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
        ]);

        // 2. Simpan data ke database
        $kelas = Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'user_id'    => Auth::id(), // Mengambil ID user yang sedang login secara otomatis
        ]);

        // 3. Response / Redirect
        // Jika menggunakan Web / Redirect back:
        return redirect()->back()->with('success', 'Kelas berhasil dibuat oleh ' . Auth::user()->name);
    }

    
}