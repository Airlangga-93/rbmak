<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    /**
     * Menampilkan daftar mitra industri.
     */
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.tables.partners.index', compact('partners'));
    }

    /**
     * Menampilkan form tambah mitra.
     */
    public function create()
    {
        return view('admin.tables.partners.create');
    }

    /**
     * Menyimpan data mitra baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'sector' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'company_contact' => 'nullable|string|max:255',
            'partnership_date' => 'required|date',
        ], [
            'name.required' => 'Nama mitra harus diisi.',
            'logo.required' => 'Logo harus diunggah.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format gambar yang diizinkan adalah jpeg, png, jpg, atau svg.',
            'logo.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'sector.required' => 'Sektor harus diisi.',
            'city.required' => 'Kota harus diisi.',
            'partnership_date.required' => 'Tanggal kerja sama harus diisi.',
        ]);

        $validatedData['slug'] = Str::slug($request->name);
        $validatedData['publisher'] = Auth::user()->name;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partner_logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        Partner::create($validatedData);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra industri berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail mitra.
     */
    public function show(Partner $partner)
    {
        return view('admin.tables.partners.show', compact('partner'));
    }

    /**
     * Menampilkan form edit mitra.
     */
    public function edit(Partner $partner)
    {
        return view('admin.tables.partners.edit', compact('partner'));
    }

    /**
     * Memperbarui data mitra di database.
     */
    public function update(Request $request, Partner $partner)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'sector' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'company_contact' => 'nullable|string|max:255',
            'partnership_date' => 'required|date',
        ], [
            'name.required' => 'Nama mitra harus diisi.',
            'sector.required' => 'Sektor harus diisi.',
            'city.required' => 'Kota harus diisi.',
            'partnership_date.required' => 'Tanggal kerja sama harus diisi.',
        ]);

        $validatedData['slug'] = Str::slug($request->name);
        $validatedData['publisher'] = Auth::user()->name;

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada dan bukan dari assets (seeder)
            if ($partner->logo && !str_contains($partner->logo, 'assets/img')) {
                Storage::disk('public')->delete($partner->logo);
            }

            $logoPath = $request->file('logo')->store('partner_logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        $partner->update($validatedData);

        return redirect()->route('admin.partners.index')->with('success', 'Mitra industri berhasil diperbarui!');
    }

    /**
     * Menghapus mitra.
     */
    public function destroy(Partner $partner)
    {
        if ($partner->logo && !str_contains($partner->logo, 'assets/img')) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Mitra industri berhasil dihapus!');
    }
}
