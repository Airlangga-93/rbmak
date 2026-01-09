@extends('admin.layouts.app')

@section('content')
    <div class="p-6 max-w-3xl">

        <h1 class="text-2xl font-semibold mb-6">Detail Feedback</h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-4">

            <div>
                <strong>Nama:</strong>
                <p>{{ $feedback->name }}</p>
            </div>

            <div>
                <strong>Email:</strong>
                <p>{{ $feedback->email }}</p>
            </div>

            <div>
                <strong>Subjek:</strong>
                <p>{{ $feedback->subject }}</p>
            </div>

            <div>
                <strong>Pesan:</strong>
                <p class="whitespace-pre-line">{{ $feedback->message }}</p>
            </div>

            <div>
                <strong>Status:</strong>
                @if ($feedback->status === 'unread')
                    <span class="text-red-600 font-semibold">Belum Dibaca</span>
                @elseif ($feedback->status === 'read')
                    <span class="text-green-600">Sudah Dibaca</span>
                @else
                    <span class="text-blue-600">Sudah Dibalas</span>
                @endif
            </div>

            <div>
                <strong>Dikirim:</strong>
                <p>{{ $feedback->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <div class="pt-4 flex gap-3">
                <a href="{{ route('admin.feedbacks.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    ⬅ Kembali
                </a>
            </div>

        </div>
    </div>
@endsection
