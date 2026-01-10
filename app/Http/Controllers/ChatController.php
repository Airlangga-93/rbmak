<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminChatNotification;

class ChatController extends Controller
{
    /**
     * TAMPILAN CHAT & API FETCH PESAN
     */
    public function index(Request $request)
    {
        $authId = Auth::id();
        $selectedUserId = $request->query('user_id');

        // Jika user biasa yang akses (bukan admin), mereka chat dengan Admin pertama yang ditemukan
        if (Auth::user()->role !== 'admin') {
            $admin = User::where('role', 'admin')->first();
            $selectedUserId = $admin ? $admin->id : null;
        }

        // Jika tidak ada user tujuan (khusus tampilan admin), tampilkan view kosong
        if (!$selectedUserId) {
            return view('admin.chat.index', ['chatUser' => null, 'messages' => collect()]);
        }

        $chatUser = User::findOrFail($selectedUserId);

        // Ambil pesan antara Auth User & Target User
        $messages = Message::where(function ($q) use ($authId, $selectedUserId) {
                $q->where('sender_id', $authId)->where('receiver_id', $selectedUserId);
            })
            ->orWhere(function ($q) use ($authId, $selectedUserId) {
                $q->where('sender_id', $selectedUserId)->where('receiver_id', $authId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mapping koleksi pesan untuk JSON/Alpine.js
        $msgCollection = $messages->map(function ($m) use ($authId) {
            return [
                'id'          => $m->id,
                'text'        => $m->message,
                'image'       => $m->image ? $this->getAttachmentUrl($m->image) : null,
                'is_me'       => (int) $m->sender_id === (int) $authId,
                'sender_type' => $m->sender_type,
                'time'        => $m->created_at->timezone('Asia/Jakarta')->format('H:i'),
                'is_read'     => $m->is_read,
                'updated_at'  => $m->updated_at->toIso8601String(),
                'created_at'  => $m->created_at->toIso8601String(),
            ];
        });

        // JIKA REQUEST AJAX / API
        if ($request->ajax() || $request->wantsJson()) {
            // Tandai pesan masuk sebagai terbaca
            Message::where('sender_id', $selectedUserId)
                   ->where('receiver_id', $authId)
                   ->where('is_read', false)
                   ->update(['is_read' => true]);

            return response()->json($msgCollection);
        }

        // TAMPILAN VIEW (Blade)
        $view = Auth::user()->role === 'admin' ? 'admin.chat.index' : 'pages.chat.index';
        return view($view, compact('chatUser', 'messages'));
    }

    /**
     * KIRIM PESAN
     */
    public function send(Request $request)
    {
        $sender = Auth::user();

        // Jika receiver_id tidak dikirim (oleh user), otomatis cari admin
        if (!$request->has('receiver_id') && $sender->role !== 'admin') {
            $admin = User::where('role', 'admin')->first();
            $request->merge(['receiver_id' => $admin->id]);
        }

        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message'     => 'required_without:image|nullable|string|max:2000',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $imagePath = null;
        $disk = config('filesystems.default') === 'cloudinary' ? 'cloudinary' : 'public';

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chats', $disk);
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

            // NOTIFIKASI EMAIL ke Admin jika pengirim adalah USER
            if ($sender->role !== 'admin') {
                $this->sendEmailNotification($message);
            }

            return response()->json([
                'status' => 'success',
                'data'   => [
                    'id'    => $message->id,
                    'text'  => $message->message,
                    'image' => $message->image ? $this->getAttachmentUrl($message->image) : null,
                    'is_me' => true,
                    'time'  => $message->created_at->timezone('Asia/Jakarta')->format('H:i')
                ]
            ]);

        } catch (\Exception $e) {
            if ($imagePath) Storage::disk($disk)->delete($imagePath);
            Log::error("Chat Send Error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Gagal mengirim pesan'], 500);
        }
    }

    /**
     * UPDATE PESAN (Sunting)
     */
    public function update(Request $request, $id)
    {
        $message = Message::where('id', $id)->where('sender_id', Auth::id())->firstOrFail();

        $request->validate([
            'message' => 'required|string|max:2000'
        ]);

        $message->update(['message' => $request->message]);

        return response()->json(['status' => 'success', 'data' => $message]);
    }

    /**
     * HAPUS PESAN
     */
    public function destroy($id)
    {
        $message = Message::where('id', $id)->where('sender_id', Auth::id())->firstOrFail();
        $disk = config('filesystems.default') === 'cloudinary' ? 'cloudinary' : 'public';

        if ($message->image) {
            Storage::disk($disk)->delete($message->image);
        }

        $message->delete();

        return response()->json(['status' => 'success']);
    }

    /**
     * HELPER: Mendapatkan URL Gambar
     */
    private function getAttachmentUrl($path)
    {
        if (!$path) return null;
        $disk = config('filesystems.default') === 'cloudinary' ? 'cloudinary' : 'public';
        return Storage::disk($disk)->url($path);
    }

    /**
     * HELPER: Kirim Email Notification
     */
    private function sendEmailNotification($message)
    {
        try {
            // Ganti ke email admin atau ambil dari config
            $adminEmail = 'iqbaliqbalnew15286@gmail.com';
            Mail::to($adminEmail)->send(new AdminChatNotification($message));
        } catch (\Exception $e) {
            Log::error("Email Notification Failed: " . $e->getMessage());
        }
    }
}
