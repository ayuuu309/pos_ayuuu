<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    /**
     * Menampilkan daftar jenis/kategori.
     */
    public function index()
    {
        $jenis = Jenis::latest()->paginate(10);
        return view('jenis.index', compact('jenis'));
    }

    /**
     * Menampilkan formulir untuk membuat jenis baru.
     */
    public function create()
    {
        return view('jenis.create');
    }

    /**
     * Menyimpan jenis baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis,nama_jenis',
        ], [
            'nama_jenis.required' => 'Nama jenis wajib diisi.',
            'nama_jenis.unique' => 'Nama jenis sudah ada.',
        ]);

        Jenis::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('jenis.index')->with('success', 'Data jenis berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail jenis (opsional).
     */
    public function show(Jenis $jeni)
    {
        return view('jenis.show', ['jenis' => $jeni]);
    }

    /**
     * Menampilkan formulir edit jenis.
     */
    public function edit(Jenis $jeni)
    {
        // Variabel $jeni menyesuaikan penamaan otomatis Laravel untuk singular dari 'jenis'
        return view('jenis.edit', ['jenis' => $jeni]);
    }

    /**
     * Memperbarui data jenis di database.
     */
    public function update(Request $request, Jenis $jeni)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis,nama_jenis,' . $jeni->id,
        ], [
            'nama_jenis.required' => 'Nama jenis wajib diisi.',
            'nama_jenis.unique' => 'Nama jenis sudah ada.',
        ]);

        $jeni->update([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('jenis.index')->with('success', 'Data jenis berhasil diperbarui!');
    }

    /**
     * Menghapus data jenis dari database.
     */
    public function destroy(Jenis $jeni)
    {
        $jeni->delete();

        return redirect()->route('jenis.index')->with('success', 'Data jenis berhasil dihapus!');
    }
}