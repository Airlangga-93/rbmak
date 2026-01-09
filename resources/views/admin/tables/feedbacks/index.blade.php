@extends('admin.layouts.app')

@section('content')
    <div class="p-6 space-y-6">

        {{-- ================= HEADER / NAVBAR SECTION ================= --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between px-6 py-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Kelola Feedback</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Daftar pesan dan masukan dari pengunjung website
                    </p>
                </div>
            </div>

            {{-- ACCENT LINE (RBM STYLE) --}}
            <div class="h-1 w-full bg-gradient-to-r from-orange-500 to-orange-300 rounded-b-xl"></div>
        </div>

        {{-- ================= ALERT ================= --}}
        @if (session('success'))
            <div class="px-4 py-3 rounded-lg bg-green-50 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- ================= TABLE PANEL ================= --}}
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">

            {{-- TABLE HEADER --}}
            <div class="px-6 py-4 border-b bg-gray-50">
                <h2 class="text-lg font-semibold text-gray-700">Data Feedback</h2>
            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">ID</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Subjek</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y text-gray-700">

                        @forelse ($feedbacks as $feedback)
                            <tr
                                class="transition hover:bg-orange-50
                            {{ $feedback->status === 'unread' ? 'bg-orange-50/50' : '' }}">

                                <td class="px-6 py-4 font-medium">{{ $feedback->id }}</td>
                                <td class="px-6 py-4">{{ $feedback->name }}</td>
                                <td class="px-6 py-4 text-gray-500">{{ $feedback->email }}</td>
                                <td class="px-6 py-4">{{ $feedback->subject }}</td>

                                {{-- STATUS --}}
                                <td class="px-6 py-4">
                                    @if ($feedback->status === 'unread')
                                        <span
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        bg-red-100 text-red-700">
                                            Belum Dibaca
                                        </span>
                                    @elseif ($feedback->status === 'read')
                                        <span
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        bg-green-100 text-green-700">
                                            Sudah Dibaca
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                        bg-blue-100 text-blue-700">
                                            Sudah Dibalas
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ $feedback->created_at->format('d/m/Y H:i') }}
                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-2">

                                        {{-- VIEW --}}
                                        <a href="{{ route('admin.feedbacks.show', $feedback) }}"
                                            class="px-4 py-2 rounded-lg text-xs font-semibold text-white
                                       bg-orange-500 hover:bg-orange-600
                                       hover:shadow-lg transition duration-200">
                                            👁 Lihat
                                        </a>

                                        {{-- DELETE --}}
                                        <form action="{{ route('admin.feedbacks.destroy', $feedback) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus feedback ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-4 py-2 rounded-lg text-xs font-semibold
                                            bg-gray-100 text-gray-700
                                            hover:bg-red-500 hover:text-white
                                            hover:shadow-lg transition duration-200">
                                                🗑 Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Tidak ada feedback
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= PAGINATION ================= --}}
        <div class="pt-2">
            {{ $feedbacks->links() }}
        </div>

    </div>
@endsection
