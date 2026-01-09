<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(15);
        return view('admin.tables.feedbacks.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        if ($feedback->status === 'unread') {
            $feedback->update(['status' => 'read']);
        }
        return view('admin.tables.feedbacks.show', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied'
        ]);

        $feedback->update(['status' => $request->status]);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Status feedback berhasil diperbarui.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
