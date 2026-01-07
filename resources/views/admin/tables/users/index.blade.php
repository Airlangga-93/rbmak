@extends('admin.layouts.app')

@section('content')
<div class="p-6 bg-[#F8FAFC] min-h-screen">

    {{-- HEADER & SEARCH --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Administrator</h1>
            <p class="text-sm text-slate-500">Kelola hak akses dan akun administrator sistem PT Sayap Sembilan Satu</p>
        </div>

        <div class="flex flex-col md:flex-row gap-3">
            {{-- Search Engine --}}
            <form action="{{ route('admin.users.index') }}" method="GET" class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari admin..."
                    class="pl-10 pr-4 py-2 w-full md:w-72 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none transition-all text-sm">
            </form>

            {{-- Tambah User --}}
            <a href="{{ route('admin.users.create') }}" class="flex items-center justify-center gap-2 px-5 py-2 bg-orange-500 text-white rounded-xl text-sm font-bold hover:bg-orange-600 transition-all shadow-lg shadow-orange-200">
                <i class="bi bi-plus-lg"></i> Tambah Admin
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Total Admin --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500">
                <i class="bi bi-shield-lock-fill text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Total Administrator</p>
                <p class="text-2xl font-bold text-slate-800">{{ $users->count() }}</p>
            </div>
        </div>

        {{-- Online Stats --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                <i class="bi bi-broadcast text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500">Admin Sedang Online</p>
                @php
                    $onlineCount = $users->filter(function($u) {
                        return $u->isOnline();
                    })->count();
                @endphp
                <p class="text-2xl font-bold text-slate-800">{{ $onlineCount }}</p>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-4 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-sm font-bold flex items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#0F172A] text-white uppercase text-[11px] tracking-widest font-bold">
                        <th class="px-6 py-4">No.</th>
                        <th class="px-6 py-4">Profil Admin</th>
                        <th class="px-6 py-4">Terdaftar Pada</th>
                        <th class="px-6 py-4">Status Aktivitas</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-5 text-sm font-medium text-slate-400">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 mt-1 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 font-bold text-sm border border-slate-200 flex-shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 leading-tight">{{ $user->name }}</p>
                                    <div class="flex flex-col gap-0.5 mt-1">
                                        <p class="text-xs text-slate-400 flex items-center gap-1">
                                            <i class="bi bi-envelope text-[10px]"></i> {{ $user->email }}
                                        </p>
                                        @if($user->phone)
                                        <p class="text-xs text-slate-400 flex items-center gap-1">
                                            <i class="bi bi-telephone text-[10px]"></i> {{ $user->phone }}
                                        </p>
                                        @endif
                                    </div>
                                    <span class="inline-block mt-2 px-2 py-0.5 bg-orange-100 text-orange-600 text-[9px] font-bold rounded uppercase tracking-wider border border-orange-200">Administrator</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 font-medium">
                            {{-- Logika tanggal pendaftaran asli dari database --}}
                            {{ $user->created_at->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-5">
                            @if($user->isOnline())
                                <div class="flex items-center">
                                    <span class="relative flex h-2 w-2 mr-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-xs font-bold text-emerald-600 uppercase">Online</span>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-xs text-slate-400 font-medium uppercase italic">Offline</span>
                                    @if($user->last_seen)
                                        <span class="text-[10px] text-slate-400">Aktif: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-8 h-8 flex items-center justify-center text-blue-500 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Edit Admin">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akses administrator untuk akun ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-red-500 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Hapus Admin">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">
                            Tidak ada data administrator yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
