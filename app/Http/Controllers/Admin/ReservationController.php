<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Menampilkan daftar semua booking (Halaman Index).
     */
    public function index()
    {
        // Ambil data terbaru dengan relasi user
        $reservations = Reservation::with('user')->latest()->paginate(10);

        // Arahkan ke folder resources/views/admin/tables/booking/index.blade.php
        return view('admin.tables.booking.index', compact('reservations'));
    }

    /**
     * Memperbarui Status & Harga
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai,batal',
            'total_price' => 'nullable|numeric|min:0',
        ]);

        try {
            $reservation = Reservation::findOrFail($id);

            $reservation->update([
                'status' => $request->status,
                'total_price' => $request->filled('total_price') ? $request->total_price : $reservation->total_price,
            ]);

            return redirect()->back()
                ->with('success', "Status Booking #{$id} berhasil diperbarui!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update data: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data booking.
     */
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Data booking berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Logika Chat Booking (DIPERBAIKI UNTUK MUNCULKAN SEMUA RIWAYAT)
     */
    public function chat($id)
    {
        $adminId = Auth::id();

        // 1. Ambil data booking utama yang sedang dibuka
        $reservation = Reservation::with('user')->findOrFail($id);
        $user = $reservation->user; // User yang sedang diajak chat

        // 2. Ambil riwayat chat antara Admin dan User ini (untuk isi chat box)
        $messages = Message::where(function ($q) use ($user, $adminId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $user->id);
            })
            ->orWhere(function ($q) use ($user, $adminId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $adminId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // 3. LOGIKA SIDEBAR: Ambil SEMUA user yang ada di riwayat reservasi
        // Ini yang membuat sidebar muncul banyak orang (semua yang pernah booking)
        $userIdsFromHistory = Reservation::pluck('user_id')->unique()->toArray();

        $active_chats = User::whereIn('id', $userIdsFromHistory)
            ->where('id', '!=', $adminId)
            ->get()
            ->map(function ($u) use ($adminId) {
                // Cari pesan terakhir untuk sub-teks sidebar
                $lastMsg = Message::where(function ($q) use ($u, $adminId) {
                        $q->where('sender_id', $adminId)->where('receiver_id', $u->id);
                    })
                    ->orWhere(function ($q) use ($u, $adminId) {
                        $q->where('sender_id', $u->id)->where('receiver_id', $adminId);
                    })
                    ->latest()
                    ->first();

                // Ambil booking terakhir user ini untuk referensi route chat
                $lastBooking = Reservation::where('user_id', $u->id)->latest()->first();

                $u->last_interaction = $lastMsg ? $lastMsg->created_at : ($lastBooking ? $lastBooking->created_at : $u->created_at);
                $u->latest_msg_text = $lastMsg ? $lastMsg->message : 'Belum ada pesan';
                $u->target_booking_id = $lastBooking ? $lastBooking->id : null;

                return $u;
            })
            ->sortByDesc('last_interaction');

        // Kembalikan ke view dengan variabel yang dibutuhkan oleh Blade
        return view('admin.tables.booking.chat', compact('reservation', 'user', 'messages', 'active_chats'));
    }
}
