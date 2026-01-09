<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail; // Tambahkan Mail
use App\Mail\AdminChatNotification; // Tambahkan Mailable

class AdminBookingController extends Controller
{
    /**
     * DAFTAR BOOKING
     */
    public function index()
    {
        $reservations = Booking::with('user')->latest()->paginate(10);
        return view('admin.tables.booking.index', compact('reservations'));
    }

    /**
     * DETAIL BOOKING
     */
    public function show($id)
    {
        $booking = Booking::with('user')->findOrFail($id);
        return view('admin.tables.booking.show', compact('booking'));
    }

    /**
     * UPDATE STATUS BOOKING
     */
    public function update(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,proses,selesai,batal']);
        Booking::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Status booking berhasil diperbarui.');
    }

    /**
     * HAPUS BOOKING
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        Message::where(function ($q) use ($booking) {
            $q->where('sender_id', $booking->user_id)
                ->orWhere('receiver_id', $booking->user_id);
        })->delete();
        $booking->delete();
        return back()->with('success', 'Booking berhasil dihapus.');
    }

    /**
     * HALAMAN CHAT ADMIN (LOGIKA TAMPILAN)
     */
    public function chat($user_id, Request $request)
    {
        $adminId = Auth::id();
        $user = User::findOrFail($user_id);

        $messages = Message::where(function ($q) use ($adminId, $user) {
            $q->where('sender_id', $adminId)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($adminId, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $adminId);
        })->orderBy('created_at')->get();

        $formattedMessages = $messages->map(function ($m) use ($adminId) {
            return [
                'id' => $m->id,
                'text' => $m->message,
                // Gunakan disk cloudinary agar gambar muncul di internet
                'image' => $m->image ? Storage::disk('cloudinary')->url($m->image) : null,
                'is_me' => $m->sender_type === 'admin',
                'time' => $m->created_at->setTimezone('Asia/Jakarta')->format('H:i'),
                'is_edited' => $m->created_at->ne($m->updated_at),
            ];
        });

        if ($request->ajax()) {
            return response()->json($formattedMessages);
        }

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $adminId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $userIds = Booking::pluck('user_id')->unique();
        $active_chats = User::whereIn('id', $userIds)->get()->map(function ($u) use ($adminId) {
            $lastMsg = Message::where(function ($q) use ($u, $adminId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $u->id);
            })->orWhere(function ($q) use ($u, $adminId) {
                $q->where('sender_id', $u->id)->where('receiver_id', $adminId);
            })->latest()->first();

            $u->latest_msg_text = $lastMsg?->message ?? 'Belum ada percakapan';
            $u->last_interaction = $lastMsg?->created_at ?? $u->created_at;
            $u->unread_count = Message::where('sender_id', $u->id)
                ->where('receiver_id', $adminId)->where('is_read', false)->count();
            return $u;
        })->sortByDesc('last_interaction');

        $activeBooking = Booking::where('user_id', $user->id)->latest()->first();

        return view('admin.tables.booking.chat', compact('user', 'formattedMessages', 'active_chats', 'activeBooking'));
    }

    /**
     * KIRIM PESAN DARI ADMIN KE USER
     */
    public function sendChat(Request $request)
    {
        $request->validate([
            'message' => 'required_without:image|nullable|string|max:1000',
            'image' => 'nullable|image|max:5120',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chats', 'cloudinary');
        }

        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'image' => $imagePath,
            'sender_type' => 'admin',
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msg->id,
                'text' => $msg->message,
                'image' => $msg->image ? Storage::disk('cloudinary')->url($msg->image) : null,
                'is_me' => true,
                'time' => $msg->created_at->setTimezone('Asia/Jakarta')->format('H:i'),
                'is_edited' => false,
            ]
        ]);
    }

    /**
     * EDIT & HAPUS PESAN
     */
    public function updateMessage(Request $request, $id) {
        $msg = Message::where('id', $id)->where('sender_id', Auth::id())->firstOrFail();
        $msg->update(['message' => $request->message]);
        return response()->json(['success' => true]);
    }

    public function deleteMessage($id) {
        $msg = Message::where('id', $id)->where('sender_id', Auth::id())->firstOrFail();
        if ($msg->image) Storage::disk('cloudinary')->delete($msg->image);
        $msg->delete();
        return response()->json(['success' => true]);
    }
}
