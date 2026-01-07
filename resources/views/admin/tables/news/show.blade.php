@extends('admin.layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $news->title }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #f0f2f5;
            }

            /* Menangani konten dari Trix agar rapi */
            .news-content img {
                max-width: 100%;
                height: auto;
                border-radius: 0.5rem;
            }
        </style>
    </head>

    <body class="bg-gray-100">

        <div class="main-content flex-1 p-4 sm:p-6">
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-[#FF7518]">
                {{-- Header --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-[#161f36] leading-tight">{{ $news->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            <i class="fas fa-user-edit mr-1"></i> {{ $news->publisher }} |
                            <i class="fas fa-calendar-alt mr-1"></i>
                            {{ \Carbon\Carbon::parse($news->date_published)->format('d F Y') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.news.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200 flex items-center shrink-0">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span>Kembali</span>
                    </a>
                </div>

                {{-- Image Container - Responsif & Menyesuaikan Ukuran Berbeda --}}
                <div class="mb-8 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 flex justify-center items-center"
                    style="min-height: 300px; max-height: 500px;">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}"
                        class="max-w-full max-h-[500px] w-auto h-auto object-contain shadow-sm">
                </div>

                {{-- Konten Berita --}}
                <div class="news-content prose max-w-none">
                    <div class="flex items-center space-x-2 mb-4">
                        <span class="h-1 w-10 bg-[#FF7518] rounded-full"></span>
                        <span class="text-xs font-bold uppercase tracking-wider text-[#FF7518]">Isi Berita</span>
                    </div>
                    <div class="text-gray-700 leading-relaxed text-lg">
                        {!! $news->description !!}
                    </div>
                </div>

                <hr class="my-8 border-gray-100">

                {{-- Tombol Aksi --}}
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('admin.news.edit', $news->id) }}"
                        class="bg-[#161f36] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#253352] transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i> Edit Konten
                    </a>

                    <form action="{{ route('admin.news.destroy', $news->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');" class="block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-50 text-red-600 border border-red-200 px-6 py-2 rounded-lg font-semibold hover:bg-red-600 hover:text-white transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-trash-alt mr-2"></i> Hapus Berita
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </body>

    </html>
@endsection
