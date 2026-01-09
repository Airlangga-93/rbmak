<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Konstruktor untuk proteksi akses.
     * Memastikan hanya user dengan role 'admin' yang bisa masuk.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                abort(403, 'Anda tidak memiliki hak akses ke halaman ini.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar Administrator dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        // Filter awal: Hanya ambil user dengan role admin
        $query = User::where('role', 'admin');

        // Fitur Pencarian khusus admin (berdasarkan nama atau email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Mengambil data terbaru
        $users = $query->latest()->get();

        return view('admin.tables.users.index', compact('users'));
    }

    /**
     * Menampilkan halaman form tambah admin.
     */
    public function create()
    {
        return view('admin.tables.users.create');
    }

    /**
     * Menyimpan data administrator baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create User Baru
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'admin', // Otomatis set sebagai admin agar muncul di daftar
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Administrator baru berhasil ditambahkan ke sistem.');
    }

    /**
     * Menampilkan halaman edit admin.
     */
    public function edit(User $user)
    {
        // Pastikan tidak bisa edit user selain admin via URL manual
        if($user->role !== 'admin') {
            abort(404);
        }

        return view('admin.tables.users.edit', compact('user'));
    }

    /**
     * Memperbarui data admin.
     */
    public function update(Request $request, User $user)
    {
        // Validasi (email unique dikecualikan untuk ID user yang sedang diupdate)
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat update
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        // Jika password diisi, maka update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Profil administrator berhasil diperbarui.');
    }

    /**
     * Menghapus admin dari sistem.
     */
    public function destroy(User $user)
    {
        // Mencegah menghapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Keamanan Sistem: Anda tidak diizinkan menghapus akun Anda sendiri saat sedang login.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akses administrator telah berhasil dicabut.');
    }
}
