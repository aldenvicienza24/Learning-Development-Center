<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'institution' => 'nullable|string|max:150',
            'contact' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:3072',
            'willing_to_contact' => 'nullable|boolean',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('feedback', 'public');
        }

        Feedback::create([
            'name' => $validated['name'],
            'institution' => $validated['institution'],
            'contact' => $validated['contact'],
            'message' => $validated['message'],
            'attachment' => $attachmentPath,
            'willing_to_contact' => $request->has('willing_to_contact') ? true : false,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih atas kritik dan saran Anda!'
            ]);
        }

        return redirect()->back()->with('feedback_success', 'Terima kasih atas kritik dan saran Anda!');
    }
}
