@extends('layouts.app')

@section('title', 'Kirim Feedback - PT. Rizqallah Boer Makmur')

@section('content')
<section class="min-h-screen bg-[#F8F9FB] pt-32 pb-20 px-4">
    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-extrabold text-[#2C3E50] mb-4 tracking-tight" data-aos="fade-down">
                Kirim Feedback
            </h2>
            <div class="w-20 h-1.5 bg-[#FFC300] mx-auto rounded-full mb-6"></div>
            <p class="text-[#7F8C8D] max-w-2xl mx-auto text-lg leading-relaxed" data-aos="fade-down" data-aos-delay="100">
                Pendapat Anda sangat berarti bagi kami. Berikan masukan, saran, atau kritik untuk membantu kami memberikan layanan yang lebih baik.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-delay="200">
            <div class="p-8 md:p-12">
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-[#2C3E50] mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FFC300] focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                                placeholder="Masukkan nama lengkap Anda" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#2C3E50] mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FFC300] focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                                placeholder="Masukkan alamat email Anda" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="block text-sm font-semibold text-[#2C3E50] mb-2">
                            Subjek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FFC300] focus:border-transparent transition-all @error('subject') border-red-500 @enderror"
                            placeholder="Subjek feedback Anda" required>
                        @error('subject')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-semibold text-[#2C3E50] mb-2">
                            Pesan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" name="message" rows="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#FFC300] focus:border-transparent transition-all resize-vertical @error('message') border-red-500 @enderror"
                            placeholder="Tuliskan feedback, saran, atau kritik Anda di sini..." required>{{ old('message') }}</textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-6">
                        <button type="submit"
                            class="flex-1 bg-[#FFC300] text-[#2C3E50] font-bold py-4 px-8 rounded-xl hover:bg-orange-400 transition-all transform hover:-translate-y-1 shadow-lg hover:shadow-xl">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Kirim Feedback
                        </button>
                        <a href="{{ route('home') }}"
                            class="flex-1 bg-gray-100 text-gray-700 font-bold py-4 px-8 rounded-xl hover:bg-gray-200 transition-all text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-[#7F8C8D] text-sm">
                Feedback Anda akan kami tanggapi dalam waktu 1-2 hari kerja.
                Terima kasih atas partisipasi Anda dalam meningkatkan kualitas layanan kami.
            </p>
        </div>
    </div>
</section>
@endsection
