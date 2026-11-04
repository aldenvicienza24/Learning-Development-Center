<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainers = Trainer::latest()->get();
        return view('admin.trainers.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trainers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'scopes' => 'required|array',
            'scopes.*' => 'string'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('trainers/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            $validated['cv'] = $request->file('cv')->store('trainers/cvs', 'public');
        }

        Trainer::create($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trainer $trainer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trainer $trainer)
    {
        return view('admin.trainers.edit', compact('trainer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'scopes' => 'required|array',
            'scopes.*' => 'string'
        ]);

        if ($request->hasFile('photo')) {
            if ($trainer->photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($trainer->photo);
            }
            $validated['photo'] = $request->file('photo')->store('trainers/photos', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($trainer->cv) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($trainer->cv);
            }
            $validated['cv'] = $request->file('cv')->store('trainers/cvs', 'public');
        }

        $trainer->update($validated);

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trainer $trainer)
    {
        if ($trainer->photo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($trainer->photo);
        }
        if ($trainer->cv) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($trainer->cv);
        }
        
        $trainer->delete();

        return redirect()->route('admin.trainers.index')->with('success', 'Trainer berhasil dihapus.');
    }
}
