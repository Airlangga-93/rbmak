<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash, Validator, Storage, Log, Mail}; // Tambahkan Mail
use App\Models\User;
use App\Models\Booking;
use App\Models\Message;
use App\Mail\AdminChatNotification; // Tambahkan Mailable
use Carbon\Carbon;

class BookingAuthController extends Controller
{
    // ID Admin Default jika belum ada admin yang merespons
    protected $defaultAdminId = 1;

    /**
     * Menampilkan halaman login booking
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('booking.index');
        }
        return view('pages.booking.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Login Admin Berhasil');
            }

            return redirect()->intended(route('booking.index'))->with('success', 'Selamat datang!');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->withInput();
    }

    /**
     * Menampilkan halaman registrasi
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('booking.index');
        }
        return view('pages.booking.registrasi');
    }

    /**
     * Proses Registrasi
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required|accepted'
        ]);

        User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('booking.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * FITUR CHAT SISI USER (LOGIKA DIPERBAIKI)
     */
    public function chat(Request $request)
    {
        $userId = Auth::id();

        // 1. Ambil semua pesan dua arah antara user ini dengan admin manapun
        $messages = Message::where(function ($q) use ($userId) {
                $q->where('sender_id', $userId);
            })
            ->orWhere(function ($q) use ($userId) {
                $q->where('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Tandai pesan masuk (dari admin) sebagai terbaca
        Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // 3. Response AJAX untuk Polling Alpine.js
        if ($request->ajax()) {
            $formattedMessages = $messages->map(function ($m) use ($userId) {
                return [
                    'id' => $m->id,
                    'text' => $m->message,
                    // Fix: Gunakan disk cloudinary agar gambar muncul di hosting
                    'image' => $m->image ? Storage::disk('cloudinary')->url($m->image) : null,
                    'sender_id' => $m->sender_id,
                    // Di sisi User: true jika pengirimnya adalah user itu sendiri (Muncul di KANAN)
                    'is_me' => (int) $m->sender_id === (int) $userId,
                    'is_edited' => $m->created_at->ne($m->updated_at),
                    'time' => $m->created_at->timezone('Asia/Jakarta')->format('H:i'),
                ];
            });
            return response()->json($formattedMessages);
        }

        $booking = Booking::where('user_id', $userId)->latest()->first();

        return view('pages.booking.chat', compact('messages', 'booking'));
    }

    /**
     * PROSES KIRIM CHAT DARI USER
     */
    public function sendChat(Request $request)
    {
        $request->validate([
            'message' => 'required_without:image|nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $userId = Auth::id();

        // Cari Admin terakhir yang merespon user ini
        $latestAdminMessage = Message::where('receiver_id', $userId)
            ->where('sender_type', 'admin')
            ->latest()
            ->first();

        // Target: admin yang membalas terakhir, atau admin ID 1
        $targetAdminId = $latestAdminMessage ? $latestAdminMessage->sender_id : $this->defaultAdminId;

        // Simpan gambar ke Cloudinary
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('chats', 'cloudinary') : null;

        try {
            $chat = Message::create([
                'booking_id' => $request->booking_id ?? null,
                'sender_id' => $userId,
                'receiver_id' => $targetAdminId,
                'message' => $request->message,
                'image' => $imagePath,
                'sender_type' => 'user',
                'is_read' => false,
                'device_info' => substr($request->userAgent(), 0, 255),
            ]);

            // LOGIKA NOTIFIKASI EMAIL KE ADMIN
            try {
                Mail::to('project@rbmak.co.id')->send(new AdminChatNotification($chat));
            } catch (\Exception $e) {
                Log::error("Gagal kirim email notifikasi chat: " . $e->getMessage());
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'id' => $chat->id,
                        'text' => $chat->message,
                        'image' => $chat->image ? Storage::disk('cloudinary')->url($chat->image) : null,
                        'is_me' => true, // User adalah pengirim
                        'time' => $chat->created_at->timezone('Asia/Jakarta')->format('H:i')
                    ]
                ]);
            }

            return back()->with('success', 'Pesan terkirim');
        } catch (\Exception $e) {
            if ($imagePath) Storage::disk('cloudinary')->delete($imagePath);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan riwayat booking
     */
    public function riwayat()
    {
        Carbon::setLocale('id');
        $bookings = Booking::where('user_id', Auth::id())->latest()->get();
        return view('pages.booking.riwayat', compact('bookings'));
    }

    /**
     * Menyimpan data booking baru
     */
    public function storeBooking(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'services' => 'required',
            'total_price' => 'required|numeric',
            'date' => 'required|date',
            'time' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()], 422);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'services' => $request->services,
            'total_price' => $request->total_price,
            'date' => $request->date,
            'time' => $request->time,
            'status' => 'pending',
        ]);

        return response()->json(['status' => 'success', 'data' => $booking]);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
