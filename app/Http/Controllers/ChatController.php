<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail; // Tambahkan ini
use App\Mail\AdminChatNotification; // Tambahkan ini

class ChatController extends Controller
{
    /**
     * TAMPILAN CHAT & API FETCH PESAN
     */
    public function index(Request $request)
    {
        $adminId = Auth::id();
        $selectedUserId = $request->query('user_id');

        // Jika tidak ada user yang dipilih, tampilkan view kosong saja
        if (!$selectedUserId) {
            return view('admin.chat.index', ['chatUser' => null]);
        }

        $chatUser = User::findOrFail($selectedUserId);

        // Ambil pesan antara Admin & User tertentu
        $messages = Message::where(function ($q) use ($adminId, $selectedUserId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $selectedUserId);
            })
            ->orWhere(function ($q) use ($adminId, $selectedUserId) {
                $q->where('sender_id', $selectedUserId)->where('receiver_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mapping koleksi pesan
        $msgCollection = $messages->map(function ($m) use ($adminId) {
            return [
                'id'      => $m->id,
                'text'    => $m->message,
                // Menggunakan disk cloudinary agar gambar muncul di hosting
                'image'   => $m->image ? Storage::disk('cloudinary')->url($m->image) : null,
                'is_me'   => (int) $m->sender_id === (int) $adminId,
                'time'    => $m->created_at->timezone('Asia/Jakarta')->format('H:i'),
                'is_read' => $m->is_read
            ];
        });

        // JIKA REQUEST AJAX (Untuk Polling Alpine.js)
        if ($request->ajax() || $request->wantsJson()) {
            // Tandai pesan sebagai terbaca saat dibuka
            Message::where('sender_id', $selectedUserId)
                   ->where('receiver_id', $adminId)
                   ->where('is_read', false)
                   ->update(['is_read' => true]);

            return response()->json($msgCollection);
        }

        // TAMPILAN BIASA
        return view('admin.chat.index', compact('chatUser'));
    }

    /**
     * KIRIM PESAN (Logika User & Admin)
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id'=> 'required|exists:users,id',
            'message'    => 'required_without:image|nullable|string|max:2000',
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        try {
            $sender = Auth::user();
            $imagePath = null;

            if ($request->hasFile('image')) {
                // Gunakan disk cloudinary sesuai setting .env anda
                $imagePath = $request->file('image')->store('chats', 'cloudinary');
            }

            $message = Message::create([
                'sender_id'   => $sender->id,
                'receiver_id' => $request->receiver_id,
                'message'     => $request->message,
                'image'       => $imagePath,
                'sender_type' => $sender->role === 'admin' ? 'admin' : 'user',
                'is_read'     => false,
                'device_info' => substr($request->userAgent(), 0, 255),
            ]);

            // LOGIKA NOTIFIKASI EMAIL:
            // Jika yang mengirim pesan adalah USER (bukan admin), kirim email ke admin
            if ($sender->role !== 'admin') {
                try {
                    Mail::to('iqbaliqbalnew15286@gmail.com')->send(new AdminChatNotification($message));
                } catch (\Exception $e) {
                    Log::error("Email gagal terkirim: " . $e->getMessage());
                    // Tetap lanjutkan agar chat masuk di website meskipun email error
                }
            }

            return response()->json([
                'status' => 'success',
                'id'     => $message->id,
                'text'   => $message->message,
                'image'  => $message->image ? Storage::disk('cloudinary')->url($message->image) : null,
                'is_me'  => true,
                'time'   => $message->created_at->timezone('Asia/Jakarta')->format('H:i')
            ]);

        } catch (\Exception $e) {
            if (isset($imagePath)) Storage::disk('cloudinary')->delete($imagePath);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * UPDATE PESAN
     */
    public function update(Request $request, $id)
    {
        $message = Message::where('id', $id)->where('sender_id', Auth::id())->firstOrFail();

        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $message->update(['message' => $request->message]);

        return response()->json(['status' => 'success']);
    }

    /**
     * HAPUS PESAN
     */
    public function destroy($id)
    {
        $message = Message::where('id', $id)->where('sender_id', Auth::id())->firstOrFail();

        if ($message->image) {
            Storage::disk('cloudinary')->delete($message->image);
        }

        $message->delete();

        return response()->json(['status' => 'success']);
    }
}
