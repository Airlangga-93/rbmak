<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.tables.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.tables.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'sector' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'partnership_date' => 'required|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['publisher'] = Auth::user()->name;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Lokasi penyimpanan di gudang storage
            $destinationPath = storage_path('app/public/partner_logos');

            // Cek jika folder belum ada, buat foldernya
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Paksa pindah file
            $file->move($destinationPath, $fileName);

            // Simpan path yang akan dipanggil oleh asset('storage/...')
            $data['logo'] = 'partner_logos/' . $fileName;
        }

        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', ' Customer berhasil ditambahkan!');
    }

    public function edit(Partner $partner)
    {
        return view('admin.tables.partners.edit', compact('partner'));
    }

    public function show(Partner $partner)
    {
        return view('admin.tables.partners.show', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'sector' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'partnership_date' => 'required|date',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name) . '-' . time();
        $data['publisher'] = Auth::user()->name;

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            $oldPath = storage_path('app/public/' . $partner->logo);
            if (File::exists($oldPath) && !str_contains($partner->logo, 'assets/')) {
                File::delete($oldPath);
            }

            $file = $request->file('logo');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/partner_logos');

            $file->move($destinationPath, $fileName);
            $data['logo'] = 'partner_logos/' . $fileName;
        }

        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', ' Customer berhasil diperbarui!');
    }

    public function destroy(Partner $partner)
    {
        $path = storage_path('app/public/' . $partner->logo);
        if (File::exists($path) && !str_contains($partner->logo, 'assets/')) {
            File::delete($path);
        }

        $partner->delete();
        return redirect()->route('admin.partners.index')->with('success', ' Customer berhasil dihapus!');
    }
}
