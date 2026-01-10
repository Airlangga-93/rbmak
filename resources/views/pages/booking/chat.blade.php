@extends('layouts.booking')

@section('title', 'Customer Chat Console - PT RBM')

@section('styles')
    <style>
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar */
        .chat-container::-webkit-scrollbar { width: 4px; }
        .chat-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        #chatBox {
            scroll-behavior: smooth;
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 20px 20px;
        }

        /* Message Animations */
        .message-in { animation: slideUp 0.3s ease-out forwards; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        /* Responsive height fix */
        .chat-wrapper { height: calc(100vh - 80px); }
        @media (max-width: 1024px) {
            .chat-wrapper { height: calc(100vh - 120px); }
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto chat-wrapper px-2 md:px-4" x-data="chatSystem()">
        <div class="grid grid-cols-12 gap-4 md:gap-6 h-full">

            {{-- MAIN CHAT AREA --}}
            <div class="col-span-12 lg:col-span-8 bg-white border border-slate-200 rounded-[24px] md:rounded-[32px] shadow-sm flex flex-col overflow-hidden relative h-full">

                {{-- HEADER --}}
                <div class="px-4 md:px-6 py-3 md:py-4 border-b border-slate-100 flex items-center justify-between glass-header sticky top-0 z-20">
                    <div class="flex items-center gap-3 md:gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-50 rounded-xl md:rounded-2xl flex items-center justify-center text-blue-600 border border-blue-100">
                                <i class="fa-solid fa-building-shield text-lg md:text-xl"></i>
                            </div>
                            <div :class="isOnline ? 'bg-green-500' : 'bg-slate-300'"
                                class="absolute -bottom-1 -right-1 w-3.5 h-3.5 border-2 border-white rounded-full transition-colors duration-500">
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-slate-800 text-sm md:text-base">Admin Rizqallah</h3>
                                <span x-show="isOnline" class="flex h-2 w-2 rounded-full bg-green-500"></span>
                            </div>
                            <p class="text-[10px] md:text-[11px] text-slate-500 font-medium tracking-wide"
                                x-text="isOnline ? 'Petugas tersedia' : 'Offline'"></p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 md:gap-4">
                         <a href="{{ route('booking.riwayat') }}" class="text-slate-400 hover:text-slate-600 p-2">
                            <i class="fa-solid fa-circle-info text-lg"></i>
                        </a>
                    </div>
                </div>

                {{-- MESSAGES BOX --}}
                <div id="chatBox" class="flex-1 overflow-y-auto p-4 md:p-6 space-y-4 md:space-y-6 chat-container">
                    <template x-for="(msg, index) in messages" :key="msg.id || index">
                        <div :class="msg.is_me ? 'flex justify-end' : 'flex justify-start'" class="group message-in">
                            <div :class="msg.is_me ? 'items-end' : 'items-start'" class="flex flex-col max-w-[85%] md:max-w-[75%]">

                                <div :class="msg.is_me ?
                                    'bg-blue-600 text-white rounded-2xl rounded-tr-none' :
                                    'bg-white border border-slate-200 text-slate-700 rounded-2xl rounded-tl-none'"
                                    class="p-3 md:p-4 shadow-sm relative transition-all group-hover:shadow-md">

                                    {{-- IMAGE HANDLING --}}
                                    <template x-if="msg.image">
                                        <div class="mb-2 overflow-hidden rounded-xl bg-slate-100 border border-black/5">
                                            <img :src="msg.image.startsWith('blob') || msg.image.startsWith('http') ? msg.image : '/storage/' + msg.image"
                                                class="max-w-full w-full cursor-zoom-in hover:opacity-95 transition-opacity object-cover"
                                                @click="window.open(msg.image.startsWith('blob') || msg.image.startsWith('http') ? msg.image : '/storage/' + msg.image)">
                                        </div>
                                    </template>

                                    <div class="relative">
                                        <p class="text-xs md:text-sm leading-relaxed whitespace-pre-wrap" x-text="msg.text"></p>
                                        <template x-if="msg.is_edited">
                                            <span class="text-[9px] opacity-60 italic block mt-1"
                                                  :class="msg.is_me ? 'text-white/80' : 'text-slate-400'">(disunting)</span>
                                        </template>
                                    </div>

                                    {{-- ACTIONS (EDIT/DELETE) --}}
                                    <div x-show="msg.is_me"
                                        class="absolute -left-10 md:-left-12 top-0 flex flex-col gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button @click="openEditModal(msg)" class="w-7 h-7 md:w-8 md:h-8 bg-white border border-slate-100 shadow-sm rounded-full text-blue-500 hover:bg-blue-50 flex items-center justify-center">
                                            <i class="fa-solid fa-pen text-[9px]"></i>
                                        </button>
                                        <button @click="openDeleteModal(msg.id)" class="w-7 h-7 md:w-8 md:h-8 bg-white border border-slate-100 shadow-sm rounded-full text-red-500 hover:bg-red-50 flex items-center justify-center">
                                            <i class="fa-solid fa-trash text-[9px]"></i>
                                        </button>
                                    </div>
                                </div>

                                <span class="text-[9px] md:text-[10px] mt-1.5 font-bold text-slate-400 uppercase tracking-wider"
                                    x-text="msg.time"></span>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- INPUT AREA --}}
                <div class="p-3 md:p-4 bg-white border-t border-slate-100 relative">
                    {{-- FILE PREVIEW POPUP --}}
                    <div x-show="fileToUpload" x-cloak
                        class="absolute bottom-full left-4 mb-4 p-2 bg-white border border-slate-200 rounded-2xl shadow-xl flex items-center gap-3 animate-bounce-short">
                        <div class="relative">
                            <img :src="filePreview" class="w-12 h-12 md:w-14 md:h-14 rounded-xl object-cover border border-slate-100">
                            <button type="button" @click="clearFile"
                                class="absolute -top-2 -right-2 bg-red-500 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] shadow-lg">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="pr-2 md:pr-4">
                            <p class="text-[8px] md:text-[9px] font-black text-slate-400 uppercase tracking-widest">Siap Dikirim</p>
                            <p class="text-[10px] md:text-xs font-bold text-slate-700 truncate max-w-[120px]" x-text="fileToUpload?.name"></p>
                        </div>
                    </div>

                    <form @submit.prevent="sendMessage()"
                        class="flex items-center gap-2 md:gap-3 bg-slate-50 p-1.5 md:p-2 rounded-2xl border border-slate-200 focus-within:border-blue-400 focus-within:bg-white transition-all shadow-inner">

                        <button type="button" @click="triggerFileInput"
                            class="w-9 h-9 md:w-10 md:h-10 flex items-center justify-center rounded-xl text-slate-400 hover:bg-white hover:text-blue-600 cursor-pointer transition-all">
                            <i class="fa-solid fa-camera text-base md:text-lg"></i>
                        </button>
                        <input type="file" id="fileInput" @change="handleFileUpload" hidden accept="image/*">

                        <input type="text" x-model="newMessage" placeholder="Tulis pesan ke admin..."
                            class="flex-1 bg-transparent border-none focus:ring-0 text-sm font-medium text-slate-700 placeholder:text-slate-400">

                        <button type="submit" :disabled="!newMessage.trim() && !fileToUpload"
                            class="px-4 md:px-5 py-2 md:py-2.5 bg-blue-600 text-white rounded-xl flex items-center justify-center shadow-md disabled:opacity-30 transition-all font-black text-[9px] md:text-[10px] uppercase tracking-widest">
                            <span class="hidden md:inline">Kirim</span>
                            <i class="fa-solid fa-paper-plane md:ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>

            {{-- SIDEBAR DETAIL (HIDDEN ON MOBILE) --}}
            <div class="hidden lg:col-span-4 lg:flex flex-col gap-4">
                <div class="bg-white border border-slate-200 rounded-[32px] p-6 shadow-sm overflow-hidden relative">
                    <h4 class="font-black text-slate-800 text-[10px] uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-600 rounded-full"></span> Detail Layanan
                    </h4>
                    <div class="space-y-4 relative z-10">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <p class="text-[9px] font-black text-slate-400 uppercase mb-1">ID Booking</p>
                            <p class="text-sm font-bold text-slate-700">#{{ $booking->id ?? '---' }}</p>
                        </div>
                        <div class="p-5 bg-gradient-to-br from-slate-800 to-slate-900 rounded-[24px] text-white shadow-lg">
                            <p class="text-[10px] font-bold opacity-60 uppercase mb-1">Total Pembayaran</p>
                            <p class="text-xl font-black">Rp {{ number_format($booking->total_price ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-[32px] p-6 shadow-sm">
                    <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Balasan Cepat</h5>
                    <div class="flex flex-col gap-2">
                        <template x-for="q in quickReplies" :key="q">
                            <button @click="newMessage = q; sendMessage()"
                                class="w-full text-left px-4 py-3 rounded-xl bg-slate-50 hover:bg-blue-50 hover:text-blue-600 text-[11px] font-bold text-slate-600 transition-all border border-transparent hover:border-blue-100">
                                <span x-text="q"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="showEditModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="bg-white rounded-[32px] w-full max-w-md shadow-2xl overflow-hidden"
                @click.away="showEditModal = false">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="font-black text-slate-800 text-xs uppercase tracking-widest">Edit Pesan</h3>
                    <button @click="showEditModal = false" class="text-slate-400 hover:text-red-500">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="p-6">
                    <textarea x-model="editText" rows="4"
                        class="w-full border border-slate-200 rounded-2xl p-4 text-sm focus:border-blue-400 outline-none ring-0 focus:ring-2 focus:ring-blue-100 transition-all"></textarea>
                </div>
                <div class="p-6 bg-slate-50 flex gap-3">
                    <button @click="showEditModal = false"
                        class="flex-1 py-3 text-xs font-black text-slate-400 hover:text-slate-600">Batal</button>
                    <button @click="updateMessage"
                        class="flex-1 py-3 bg-blue-600 text-white rounded-xl text-xs font-black shadow-lg hover:bg-blue-700 transition-colors">Simpan</button>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="showDeleteModal" x-cloak
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100">
            <div class="bg-white rounded-[32px] w-full max-w-sm shadow-2xl overflow-hidden text-center p-8"
                @click.away="showDeleteModal = false">
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-trash-can text-2xl"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 mb-2">Hapus Pesan?</h3>
                <p class="text-sm text-slate-500 mb-6">Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                        class="flex-1 py-3 text-xs font-black text-slate-400">Batal</button>
                    <button @click="deleteMsg"
                        class="flex-1 py-3 bg-red-500 text-white rounded-2xl text-xs font-black shadow-lg hover:bg-red-600 transition-colors">Ya, Hapus</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function chatSystem() {
            return {
                currentUserId: {{ auth()->id() }},
                messages: [],
                newMessage: '',
                fileToUpload: null,
                filePreview: '',
                isOnline: true,
                showEditModal: false,
                showDeleteModal: false,
                editingId: null,
                editText: '',
                deletingId: null,
                quickReplies: ['Bagaimana status pesanan?', 'Bisa minta update progres?', 'Terima kasih!'],

                init() {
                    const initialData = {!! json_encode($messages->map(fn($m) => [
                        'id' => $m->id,
                        'message' => $m->message,
                        'image' => $m->image,
                        'sender_id' => $m->sender_id,
                        'sender_type' => $m->sender_type,
                        'created_at' => $m->created_at->toIso8601String(),
                        'updated_at' => $m->updated_at->toIso8601String(),
                        'time' => $m->created_at->timezone('Asia/Jakarta')->format('H:i'),
                    ])) !!};

                    this.messages = this.formatMessages(initialData);
                    this.scrollToBottom();
                    setInterval(() => this.fetchMessages(), 4000);
                },

                formatMessages(rawMessages) {
                    return rawMessages.map(m => ({
                        id: m.id,
                        text: m.message,
                        image: m.image,
                        is_me: m.sender_type.toLowerCase() === 'user' && parseInt(m.sender_id) === this.currentUserId,
                        is_edited: (new Date(m.updated_at).getTime() - new Date(m.created_at).getTime()) > 2000,
                        time: m.time
                    }));
                },

                triggerFileInput() { document.getElementById('fileInput').click(); },

                handleFileUpload(e) {
                    const file = e.target.files[0];
                    if (file) {
                        if (file.size > 5 * 1024 * 1024) {
                            alert('File maksimal 5MB');
                            return;
                        }
                        this.fileToUpload = file;
                        this.filePreview = URL.createObjectURL(file);
                    }
                },

                clearFile() {
                    this.fileToUpload = null;
                    if (this.filePreview) URL.revokeObjectURL(this.filePreview);
                    this.filePreview = '';
                    document.getElementById('fileInput').value = '';
                },

                async sendMessage() {
                    if (!this.newMessage.trim() && !this.fileToUpload) return;

                    const formData = new FormData();
                    formData.append('message', this.newMessage);
                    formData.append('booking_id', '{{ $booking->id ?? "" }}');
                    if (this.fileToUpload) formData.append('image', this.fileToUpload);

                    // Optimistic UI updates
                    const tempText = this.newMessage;
                    this.newMessage = '';
                    this.clearFile();

                    try {
                        const response = await fetch('{{ route("chat.send") }}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                                // JANGAN set Content-Type secara manual saat menggunakan FormData
                            }
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        await this.fetchMessages();
                        this.scrollToBottom();
                    } catch (err) {
                        alert('Gagal mengirim pesan. Cek koneksi Anda.');
                        this.newMessage = tempText;
                    }
                },

                async fetchMessages() {
                    try {
                        const response = await fetch('{{ route("chat.index") }}?ajax=1');
                        if (response.ok) {
                            const data = await response.json();
                            this.messages = this.formatMessages(data);
                        }
                    } catch (e) { console.error("Fetch error", e); }
                },

                openEditModal(msg) {
                    this.editingId = msg.id;
                    this.editText = msg.text;
                    this.showEditModal = true;
                },

                async updateMessage() {
                    if (!this.editText.trim()) return;
                    try {
                        const response = await fetch(`/booking/chat/update/${this.editingId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ message: this.editText })
                        });
                        if (response.ok) {
                            await this.fetchMessages();
                            this.showEditModal = false;
                        }
                    } catch (err) { console.error(err); }
                },

                openDeleteModal(id) {
                    this.deletingId = id;
                    this.showDeleteModal = true;
                },

                async deleteMsg() {
                    try {
                        const response = await fetch(`/booking/chat/message/${this.deletingId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        if (response.ok) {
                            this.messages = this.messages.filter(m => m.id !== this.deletingId);
                            this.showDeleteModal = false;
                        }
                    } catch (err) { console.error(err); }
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const box = document.getElementById('chatBox');
                        if (box) box.scrollTop = box.scrollHeight;
                    });
                }
            }
        }
    </script>
@endsection
