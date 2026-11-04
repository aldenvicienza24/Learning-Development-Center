<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::latest()->paginate(15);
        
        // Mark all as read when viewed (optional, or mark specific ones)
        // Feedback::where('is_read', false)->update(['is_read' => true]);

        return view('admin.feedbacks.index', compact('feedbacks'));
    }

    public function attachment(Feedback $feedback)
    {
        if (!$feedback->attachment || !\Illuminate\Support\Facades\Storage::disk('public')->exists($feedback->attachment)) {
            abort(404, 'Lampiran tidak ditemukan.');
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->response($feedback->attachment);
    }

    public function destroy(Feedback $feedback)
    {
        if ($feedback->attachment) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($feedback->attachment);
        }
        $feedback->delete();

        return redirect()->back()->with('status', 'Kritik & saran berhasil dihapus.');
    }
}
