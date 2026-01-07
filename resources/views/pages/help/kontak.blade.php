@extends('layouts.app')

@section('title', 'Hubungi Kami - PT. Rizqallah Boer Makmur')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <section class="min-h-screen bg-[#F8F9FB] pt-32 pb-20 px-4">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-5xl font-extrabold text-[#2C3E50] mb-4 tracking-tight" data-aos="fade-down">
                    Hubungi Kami
                </h2>
                <div class="w-20 h-1.5 bg-[#FFC300] mx-auto rounded-full mb-6"></div>
                <p class="text-[#7F8C8D] max-w-2xl mx-auto text-lg leading-relaxed" data-aos="fade-down" data-aos-delay="100">
                    Tim kami siap membantu Anda dengan pertanyaan mengenai proyek, layanan, atau kemitraan bisnis.
                </p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" data-aos="fade-up"
                data-aos-delay="200">
                <div class="grid grid-cols-1 lg:grid-cols-3 divide-y lg:divide-y-0 lg:divide-x divide-gray-100">

                    <div class="p-8 md:p-12">
                        <h3 class="text-xl font-bold text-[#2C3E50] mb-8 pb-3 border-b-2 border-gray-50 flex items-center">
                            <span class="w-8 h-1 bg-[#FFC300] mr-3 rounded-full"></span>
                            Kontak Utama
                        </h3>

                        <div class="space-y-8">
                            <div class="flex items-start gap-4 group">
                                <div class="text-3xl text-[#FFC300] transition-transform group-hover:scale-110">
                                    <i class="bi bi-headset"></i>
                                </div>
                                <div>
                                    <a href="tel:+6221XXXXXXX"
                                        class="text-lg font-semibold text-[#2C3E50] hover:text-[#FFC300] transition-colors">
                                        0813 9488 4596
                                    </a>
                                    <p class="text-sm text-[#7F8C8D] mt-1">Dwi Yudho M</p>
                                </div>
                            </div>

                            <h3
                                class="text-xl font-bold text-[#2C3E50] mb-8 pb-3 border-b-2 border-gray-50 flex items-center">
                                <span class="w-8 h-1 bg-[#FFC300] mr-3 rounded-full"></span>
                                Sales Marketing
                            </h3>

                            <div class="flex items-start gap-4 group">
                                <div class="text-3xl text-[#FFC300] transition-transform group-hover:scale-110">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-[#7F8C8D] mt-1">Arif Endi</p>
                                    <a href="https://wa.me/6281234567890" target="_blank"
                                        class="text-lg font-semibold text-[#2C3E50] hover:text-[#FFC300] transition-colors">
                                        0821 2123 3261
                                    </a>
                                    <p class="text-sm text-[#7F8C8D] mt-1">Dwi Yudho M</p>
                                    <a href="https://wa.me/6281234567890" target="_blank"
                                        class="text-lg font-semibold text-[#2C3E50] hover:text-[#FFC300] transition-colors">
                                        0813 9488 4596
                                    </a>
                                </div>
                            </div>

                            <h3
                                class="text-xl font-bold text-[#2C3E50] mb-8 pb-3 border-b-2 border-gray-50 flex items-center">
                                <span class="w-8 h-1 bg-[#FFC300] mr-3 rounded-full"></span>
                                Operasional dan Project
                            </h3>
                            <div class="flex items-start gap-4 group">
                                <div class="text-3xl text-[#FFC300] transition-transform group-hover:scale-110">
                                    <i class="bi bi-briefcase"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-[#7F8C8D] mt-1">Delar</p>
                                    <a href="https://wa.me/6281234567890" target="_blank"
                                        class="text-lg font-semibold text-[#2C3E50] hover:text-[#FFC300] transition-colors">
                                        0852 2233 1343
                                    </a>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="p-8 md:p-12 bg-gray-50/50">
                        <h3 class="text-xl font-bold text-[#2C3E50] mb-6 pb-3 border-b-2 border-gray-100 flex items-center">
                            <span class="w-8 h-1 bg-[#FFC300] mr-3 rounded-full"></span>
                            Lokasi Kami
                        </h3>
                        <p class="text-sm text-[#7F8C8D] mb-6 italic">Kunjungi kantor kami. Mohon buat janji temu
                            terlebih dahulu.</p>
                        <br>
                        <br>
                        <div class="rounded-2xl overflow-hidden shadow-inner border border-gray-200 h-32 lg:h-36">
                            <iframe class="w-full h-full"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.8975!2d107.8323199!3d-6.9113491!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68dbb5021f6cbd%3A0x2b5772b4460f8ef9!2sWH%20RBM!5e0!3m2!1sid!2sid!4v1736400000000"
                                style="border:0;" allowfullscreen loading="lazy">
                            </iframe>
                        </div>

                    </div>

                    <div class="p-8 md:p-12">
                        <h3 class="text-xl font-bold text-[#2C3E50] mb-8 pb-3 border-b-2 border-gray-50 flex items-center">
                            <span class="w-8 h-1 bg-[#FFC300] mr-3 rounded-full"></span>
                            Digital & Media
                        </h3>

                        <div class="mb-10">
                            <h4 class="text-xs uppercase tracking-widest font-bold text-[#7F8C8D] mb-4">Email Resmi</h4>
                            <div class="space-y-4">
                                <a href="mailto:info@towermanagement.com"
                                    class="flex items-center gap-3 text-[#2C3E50] font-semibold hover:text-[#FFC300] transition group">
                                    <i class="bi bi-envelope-at-fill text-xl text-[#FFC300]"></i>
                                    marketing@rbmak.co.id

                                </a>
                                <a href="mailto:careers@towermanagement.com"
                                    class="flex items-center gap-3 text-[#2C3E50] font-semibold hover:text-[#FFC300] transition group">
                                    <i class="bi bi-person-workspace text-xl text-[#FFC300]"></i>
                                    project@rbmak.co.id
                                </a>
                            </div>
                        </div>

                        <div>

                            <div class="flex items-start gap-4 group">
                                <div class="text-3xl text-[#FFC300] transition-transform group-hover:scale-110">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <span class="text-base font-medium text-[#2C3E50] leading-relaxed">
                                        Menara Palma Lantai 12
                                        Jl. HR. Rasuna Said Kav. 6 Blok X-2
                                        Jakarta Selatan 12950F
                                    </span>
                                    <p class="text-sm text-[#7F8C8D] mt-1">Head Office</p>
                                </div>


                                
                            </div>

                            <div class="flex items-start gap-4 group">
                                <div class="text-3xl text-[#FFC300] transition-transform group-hover:scale-110">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <span class="text-base font-medium text-[#2C3E50] leading-relaxed">
                                        Jl. Cilembu Haurngombong
                                        (Perempatan Warung Kawat)
                                        RT.01, RW.03 Kec. Pamulihan
                                        Sumedang 45365
                                    </span>
                                    <p class="text-sm text-[#7F8C8D] mt-1">Warehouse</p>
                                </div>
                            </div>

                            

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
