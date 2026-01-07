@extends('admin.layouts.app')

@section('title', 'Admin Chat Console')

@section('styles')
    <style>
        [x-cloak] { display: none !important; }

        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        #chat-box {
            scroll-behavior: smooth;
            background-color: #f8fafc;
            background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
            background-size: 20px 20px;
        }

        .message-anim { animation: slideIn 0.2s ease-out forwards; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-2 py-4 h-[calc(100vh-100px)]" x-data="adminChat()">
        <div class="flex h-full bg-white rounded-[32px] shadow-2xl border border-slate-200 overflow-hidden relative">

            {{-- SIDEBAR --}}
            <div class="w-72 border-r border-slate-100 flex flex-col bg-slate-50/50">
                <div class="p-5 border-b border-slate-100 bg-white">
                    <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Messages</h2>
                    <div class="relative">
                        <input x-model="search" placeholder="Cari pelanggan..."
                            class="w-full bg-slate-100 border-none rounded-xl px-4 py-2.5 text-xs outline-none focus:ring-2 focus:ring-orange-500/20 transition-all">
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-1">
                    @foreach ($active_chats as $ac)
                        <a href="{{ route('admin.booking.chat', $ac->id) }}"
                            class="flex items-center gap-3 p-3 rounded-2xl transition-all {{ $user && $user->id == $ac->id ? 'bg-orange-600 text-white shadow-lg shadow-orange-200' : 'hover:bg-white text-slate-600 hover:shadow-sm' }}"
                            x-show="search === '' || '{{ strtolower($ac->name) }}'.includes(search.toLowerCase())">

                            <div class="w-10 h-10 shrink-0 rounded-xl flex items-center justify-center font-bold {{ $user && $user->id == $ac->id ? 'bg-white/20 text-white' : 'bg-orange-100 text-orange-600' }}">
                                {{ strtoupper(substr($ac->name, 0, 1)) }}
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold text-xs truncate">{{ $ac->name }}</p>
                                    @if ($ac->unread_count > 0)
                                        <span class="bg-red-500 text-[8px] text-white px-1.5 py-0.5 rounded-full shadow-sm animate-pulse">{{ $ac->unread_count }}</span>
                                    @endif
                                </div>
                                <p class="text-[10px] truncate opacity-70">{{ $ac->latest_msg_text }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- CHAT AREA --}}
            <div class="flex-1 flex flex-col bg-white">
                @if ($user)
                    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-white/80 backdrop-blur-md z-10">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 shadow-inner border border-orange-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M7.5 6.5C7.5 8.981 9.519 11 12 11s4.5-2.019 4.5-4.5S14.481 2 12 2 7.5 4.019 7.5 6.5zM20 21h1v-1c0-3.859-3.141-7-7-7h-4c-3.86 0-7 3.141-7 7v1h17z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-sm text-slate-800">{{ $user->name }}</h3>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Active Now</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="chat-box" class="flex-1 p-6 overflow-y-auto space-y-6 custom-scrollbar">
                        <template x-for="(msg, index) in messages" :key="msg.id || index">
                            <div :class="msg.is_me ? 'justify-end' : 'justify-start'" class="flex message-anim group">
                                <div :class="msg.is_me ? 'items-end' : 'items-start'" class="flex flex-col max-w-[75%]">

                                    <div class="relative flex items-center gap-2">
                                        {{-- TOMBOL EDIT & DELETE (SVG) --}}
                                        <template x-if="msg.is_me">
                                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button @click="openEditModal(msg)" class="w-8 h-8 bg-white shadow-md border border-slate-200 rounded-full text-blue-600 hover:bg-blue-50 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                                </button>
                                                <button @click="openDeleteModal(msg.id)" class="w-8 h-8 bg-white shadow-md border border-slate-200 rounded-full text-red-600 hover:bg-red-50 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                </button>
                                            </div>
                                        </template>

                                        <div :class="msg.is_me ? 'bg-orange-600 text-white rounded-2xl rounded-tr-none shadow-lg' : 'bg-white border border-slate-200 text-slate-700 rounded-2xl rounded-tl-none shadow-sm'" class="p-4">
                                            <template x-if="msg.image">
                                                <div class="mb-3">
                                                    <img :src="msg.image" class="rounded-xl max-h-64 w-full object-cover shadow-sm border border-black/5">
                                                </div>
                                            </template>
                                            <p class="text-sm leading-relaxed whitespace-pre-wrap font-medium" x-text="msg.text"></p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-2 mt-2">
                                        <span class="text-[9px] font-bold text-slate-400 px-1" x-text="msg.time"></span>
                                        <template x-if="msg.is_edited">
                                            <span class="text-[8px] italic text-slate-400">(edited)</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- INPUT AREA --}}
                    <div class="p-5 bg-white border-t border-slate-100">
                        {{-- IMAGE PREVIEW --}}
                        <div x-show="fileToUpload" x-cloak class="mb-4 inline-flex items-center gap-4 bg-slate-900 text-white p-2 rounded-2xl shadow-xl animate-bounce">
                            <div class="relative group">
                                <img :src="filePreview" class="w-16 h-16 rounded-xl object-cover">
                                <button @click="clearFile" class="absolute -top-3 -right-3 bg-red-600 text-white w-7 h-7 rounded-full flex items-center justify-center shadow-lg border-2 border-white z-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            <div class="pr-4">
                                <p class="text-[10px] font-black uppercase text-orange-400 tracking-widest">Image Ready</p>
                                <p class="text-[9px] opacity-60">Click plane to send</p>
                            </div>
                        </div>

                        <div class="flex items-end gap-3 bg-slate-50 p-2 rounded-[24px] border border-slate-200 focus-within:border-orange-500 focus-within:bg-white transition-all shadow-inner">

                            {{-- TOMBOL KAMERA (SVG) --}}
                            <button @click="$refs.fileInput.click()" class="w-11 h-11 bg-white rounded-2xl shadow-sm text-slate-500 hover:text-orange-600 border border-slate-100 flex items-center justify-center transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </button>
                            <input type="file" x-ref="fileInput" @change="handleFileUpload" hidden accept="image/*">

                            <textarea x-model="newMessage" @keydown.enter.prevent="sendMessage()" rows="1" class="flex-1 bg-transparent border-none focus:ring-0 text-sm py-3 px-2 resize-none placeholder:text-slate-400" placeholder="Type message..."></textarea>

                            {{-- TOMBOL KIRIM (SVG) --}}
                            <button @click="sendMessage()" :disabled="!newMessage.trim() && !fileToUpload" class="w-11 h-11 bg-orange-600 text-white rounded-2xl flex items-center justify-center shadow-lg disabled:opacity-20 hover:bg-orange-700 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 rotate-90" fill="currentColor" viewBox="0 0 24 24"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/></svg>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center text-slate-300">
                        <div class="w-24 h-24 bg-slate-50 rounded-[40px] flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" /></svg>
                        </div>
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Select a conversation</p>
                    </div>
                @endif
            </div>

            {{-- RIGHT PANEL --}}
            @if ($user)
                <div class="w-80 border-l border-slate-100 bg-slate-50/30 p-6 flex flex-col gap-6 overflow-y-auto custom-scrollbar">
                    <div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Customer Info</h4>
                        <div class="bg-white p-5 rounded-[24px] border border-slate-100 shadow-sm space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">Email</p>
                                    <p class="text-xs font-bold text-slate-700 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $activeBooking = \App\Models\Booking::where('user_id', $user->id)->latest()->first();
                    @endphp

                    @if ($activeBooking)
                        <div>
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Current Order</h4>
                            <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden">
                                <div class="p-5 border-b border-slate-50 bg-orange-50/50">
                                    <p class="text-[10px] font-black text-orange-600 uppercase">#{{ str_pad($activeBooking->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    <h5 class="text-xs font-bold text-slate-700">Order Details:</h5>
                                </div>

                                <div class="p-5 space-y-3">
                                    @php
                                        $services = is_array($activeBooking->services) ? $activeBooking->services : explode(',', $activeBooking->services);
                                    @endphp

                                    @if(count($services) > 0 && $services[0] != "")
                                        @foreach($services as $serviceName)
                                            <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-50 border border-slate-100">
                                                <div class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                                </div>
                                                <p class="text-xs font-bold text-slate-700 truncate">{{ trim($serviceName) }}</p>
                                            </div>
                                        @endforeach
                                    @endif

                                    <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                                        <span class="text-[10px] font-black text-slate-400 uppercase">Total Bill</span>
                                        <span class="text-sm font-black text-orange-600">Rp{{ number_format($activeBooking->total_price ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="p-5 bg-slate-50 border-t border-slate-100">
                                    <form action="{{ route('admin.booking.update', $activeBooking->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="w-full bg-white border-slate-200 rounded-xl text-[10px] font-black py-2.5 uppercase cursor-pointer">
                                            <option value="pending" {{ $activeBooking->status == 'pending' ? 'selected' : '' }}>🕒 Pending</option>
                                            <option value="proses" {{ $activeBooking->status == 'proses' ? 'selected' : '' }}>⚙️ Proses</option>
                                            <option value="selesai" {{ $activeBooking->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                                            <option value="batal" {{ $activeBooking->status == 'batal' ? 'selected' : '' }}>❌ Batal</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- MODAL EDIT --}}
        <div x-show="showEditModal" x-cloak x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4">
            <div class="bg-white rounded-[32px] p-8 w-full max-w-md shadow-2xl" @click.away="showEditModal = false">
                <h3 class="font-black text-slate-800 uppercase mb-6">Edit Message</h3>
                <textarea x-model="editText" class="w-full border-slate-100 bg-slate-50 rounded-[24px] p-5 text-sm" rows="4"></textarea>
                <div class="flex gap-3 mt-6">
                    <button @click="showEditModal = false" class="flex-1 py-4 text-xs font-black text-slate-400 uppercase">Cancel</button>
                    <button @click="updateMessage()" class="flex-1 py-4 bg-orange-600 text-white rounded-2xl text-xs font-black uppercase shadow-lg">Update</button>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="showDeleteModal" x-cloak x-transition.opacity class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4">
            <div class="bg-white rounded-[32px] p-8 w-full max-w-sm shadow-2xl text-center" @click.away="showDeleteModal = false">
                <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                </div>
                <h3 class="font-black text-slate-800 uppercase mb-2">Delete Message?</h3>
                <p class="text-xs text-slate-400 mb-8">This action cannot be undone.</p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false" class="flex-1 py-4 text-xs font-black text-slate-400 uppercase">No</button>
                    <button @click="deleteMessage()" class="flex-1 py-4 bg-red-600 text-white rounded-2xl text-xs font-black uppercase shadow-lg">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function adminChat() {
            return {
                search: '',
                messages: @json($formattedMessages ?? []),
                newMessage: '',
                fileToUpload: null,
                filePreview: '',
                showEditModal: false,
                showDeleteModal: false,
                editingId: null,
                editText: '',
                deletingId: null,

                handleFileUpload(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.fileToUpload = file;
                        this.filePreview = URL.createObjectURL(file);
                    }
                },

                clearFile() {
                    if (this.filePreview) URL.revokeObjectURL(this.filePreview);
                    this.fileToUpload = null;
                    this.filePreview = '';
                    this.$refs.fileInput.value = '';
                },

                async sendMessage() {
                    if (!this.newMessage.trim() && !this.fileToUpload) return;
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('receiver_id', '{{ $user->id ?? '' }}');
                    formData.append('message', this.newMessage);
                    if (this.fileToUpload) formData.append('image', this.fileToUpload);

                    try {
                        const response = await fetch('{{ route('admin.chat.send') }}', {
                            method: 'POST',
                            body: formData,
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const result = await response.json();
                        if (result.success) {
                            this.messages.push(result.message);
                            this.newMessage = '';
                            this.clearFile();
                            this.scrollToBottom();
                        }
                    } catch (e) { console.error('Error'); }
                },

                openEditModal(msg) {
                    this.editingId = msg.id;
                    this.editText = msg.text;
                    this.showEditModal = true;
                },

                async updateMessage() {
                    try {
                        const res = await fetch(`/admin/booking/chat/update/${this.editingId}`, {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' },
                            body: JSON.stringify({ message: this.editText })
                        });
                        const data = await res.json();
                        if (data.success) {
                            const msg = this.messages.find(m => m.id === this.editingId);
                            if (msg) { msg.text = this.editText; msg.is_edited = true; }
                            this.showEditModal = false;
                        }
                    } catch (e) { alert('Failed'); }
                },

                openDeleteModal(id) {
                    this.deletingId = id;
                    this.showDeleteModal = true;
                },

                async deleteMessage() {
                    try {
                        const res = await fetch(`/admin/booking/chat/message/${this.deletingId}`, {
                            method: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        if ((await res.json()).success) {
                            this.messages = this.messages.filter(m => m.id !== this.deletingId);
                            this.showDeleteModal = false;
                        }
                    } catch (e) { alert('Failed'); }
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const box = document.getElementById('chat-box');
                        if (box) box.scrollTop = box.scrollHeight;
                    });
                },

                init() {
                    this.scrollToBottom();
                    setInterval(async () => {
                        if ('{{ $user->id ?? '' }}' !== "") {
                            try {
                                const res = await fetch(`{{ request()->fullUrl() }}`, {
                                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                                });
                                if (res.ok) {
                                    const data = await res.json();
                                    if (data.length !== this.messages.length) {
                                        this.messages = data;
                                        this.scrollToBottom();
                                    }
                                }
                            } catch (e) { }
                        }
                    }, 3000);
                }
            }
        }
    </script>
@endsection
