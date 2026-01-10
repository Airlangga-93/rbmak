@extends('admin.layouts.app')

@section('content')
<div class="p-4 md:p-6 bg-[#F8FAFC] min-h-screen">

    {{-- HEADER & SEARCH --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-6">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Daftar Administrator</h1>
            <p class="text-sm text-slate-500">Kelola hak akses dan akun administrator sistem PT Rizqallah Boer Makmur</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            {{-- Search Engine --}}
            <form action="{{ route('admin.users.index') }}" method="GET" class="relative flex-1 sm:flex-none">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari admin..."
                    class="pl-10 pr-4 py-2.5 w-full lg:w-72 rounded-xl border border-slate-200 focus:border-orange-500 focus:ring-4 focus:ring-orange-100 outline-none transition-all text-sm">
            </form>

            {{-- Tambah User --}}
            <a href="{{ route('admin.users.create') }}" class="flex items-center justify-center gap-2 px-6 py-2.5 bg-orange-500 text-white rounded-xl text-sm font-black hover:bg-orange-600 transition-all shadow-lg shadow-orange-200 active:scale-95">
                <i class="bi bi-plus-lg"></i> Tambah Admin
            </a>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
        {{-- Total Admin --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500 shrink-0">
                <i class="bi bi-shield-lock-fill text-2xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Administrator</p>
                <p class="text-2xl font-bold text-slate-800 leading-none">{{ $users->count() }}</p>
            </div>
        </div>

        {{-- Online Stats --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center space-x-4">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 shrink-0">
                <i class="bi bi-broadcast text-2xl"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Admin Sedang Online</p>
                @php
                    $onlineCount = $users->filter(function($u) {
                        return $u->isOnline();
                    })->count();
                @endphp
                <p class="text-2xl font-bold text-slate-800 leading-none">{{ $onlineCount }}</p>
            </div>
        </div>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-600 rounded-xl text-sm font-bold flex items-center gap-2 animate-in fade-in slide-in-from-top-2">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- DATA SECTION --}}
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">

        {{-- 🖥️ DESKTOP VIEW (Hanya MD ke atas) --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white uppercase text-[10px] tracking-[0.2em] font-black">
                        <th class="px-6 py-5">No.</th>
                        <th class="px-6 py-5">Profil Admin</th>
                        <th class="px-6 py-5">Terdaftar</th>
                        <th class="px-6 py-5">Status</th>
                        <th class="px-6 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-5 text-xs font-bold text-slate-400">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 mt-1 bg-slate-100 rounded-xl flex items-center justify-center text-slate-600 font-bold text-sm border border-slate-200 shrink-0 group-hover:bg-white transition-colors">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-slate-800 leading-tight truncate">{{ $user->name }}</p>
                                    <div class="flex flex-col gap-0.5 mt-1">
                                        <p class="text-[11px] text-slate-400 flex items-center gap-1">
                                            <i class="bi bi-envelope"></i> {{ $user->email }}
                                        </p>
                                        @if($user->phone)
                                        <p class="text-[11px] text-slate-400 flex items-center gap-1">
                                            <i class="bi bi-telephone"></i> {{ $user->phone }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-slate-500">{{ $user->created_at->translatedFormat('d M Y') }}</span>
                        </td>
                        <td class="px-6 py-5">
                            @if($user->isOnline())
                                <div class="flex items-center">
                                    <span class="relative flex h-2 w-2 mr-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Online</span>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-slate-300 font-black uppercase tracking-widest">Offline</span>
                                    @if($user->last_seen)
                                        <span class="text-[10px] text-slate-400 italic">Aktif: {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }}</span>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="w-9 h-9 flex items-center justify-center text-blue-500 hover:bg-blue-600 hover:text-white rounded-xl transition-all border border-slate-100 hover:border-blue-600 shadow-sm" title="Edit Admin">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akses administrator untuk akun ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-500 hover:bg-red-600 hover:text-white rounded-xl transition-all border border-slate-100 hover:border-red-600 shadow-sm" title="Hapus Admin">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">No data found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 📱 MOBILE VIEW (Hanya muncul di HP) --}}
        <div class="md:hidden divide-y divide-slate-100">
            @forelse($users as $user)
                <div class="p-5 flex flex-col space-y-4">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600 font-black text-lg border border-slate-200">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-sm leading-none mb-1">{{ $user->name }}</h3>
                                <p class="text-[11px] text-slate-400">{{ $user->email }}</p>
                                <span class="inline-block mt-1 px-2 py-0.5 bg-orange-50 text-orange-600 text-[8px] font-black rounded uppercase border border-orange-100">Administrator</span>
                            </div>
                        </div>
                        <div>
                            @if($user->isOnline())
                                <span class="flex h-3 w-3 rounded-full bg-emerald-500 border-2 border-white shadow-sm shadow-emerald-200"></span>
                            @else
                                <span class="flex h-3 w-3 rounded-full bg-slate-300 border-2 border-white"></span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-4 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Terdaftar Pada</p>
                            <p class="text-xs font-bold text-slate-600">{{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Status Login</p>
                            @if($user->isOnline())
                                <p class="text-xs font-bold text-emerald-600 uppercase">Sedang Aktif</p>
                            @else
                                <p class="text-[10px] font-medium text-slate-400 italic">{{ $user->last_seen ? \Carbon\Carbon::parse($user->last_seen)->diffForHumans() : 'Belum Pernah' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="flex-1 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl text-[10px] font-black uppercase text-center active:bg-slate-50">
                            Edit Profil
                        </a>
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-3 bg-red-50 text-red-600 rounded-xl text-[10px] font-black uppercase text-center active:bg-red-100 border border-red-100">
                                Hapus Akses
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="p-10 text-center text-slate-400 italic">Tidak ada data.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
