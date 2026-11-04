<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerDiscount;
use App\Models\Program;
use Illuminate\Http\Request;

class PartnerDiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerDiscount::query()
            ->with('program')
            ->withCount('registrations');

        if ($request->filled('search')) {
            $search = '%' . trim($request->input('search')) . '%';
            $query->where(function ($q) use ($search) {
                $q->where('institution_name', 'like', $search)
                    ->orWhere('email_domain', 'like', $search)
                    ->orWhere('notes', 'like', $search);
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $discounts = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.partner-discounts.index', compact('discounts'));
    }

    public function create()
    {
        $programs = Program::orderBy('title')->get(['id', 'title']);

        return view('admin.partner-discounts.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:150'],
            'email_domain' => ['required', 'string', 'max:100'],
            'discount_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'is_active' => ['boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        PartnerDiscount::create($validated);

        return redirect()->route('admin.partner-discounts.index')->with('status', 'Diskon kemitraan berhasil ditambahkan.');
    }

    public function edit(PartnerDiscount $partnerDiscount)
    {
        $programs = Program::orderBy('title')->get(['id', 'title']);

        return view('admin.partner-discounts.edit', compact('partnerDiscount', 'programs'));
    }

    public function update(Request $request, PartnerDiscount $partnerDiscount)
    {
        $validated = $request->validate([
            'institution_name' => ['required', 'string', 'max:150'],
            'email_domain' => ['required', 'string', 'max:100'],
            'discount_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'is_active' => ['boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $partnerDiscount->update($validated);

        return redirect()->route('admin.partner-discounts.index')->with('status', 'Diskon kemitraan berhasil diperbarui.');
    }

    public function destroy(PartnerDiscount $partnerDiscount)
    {
        $partnerDiscount->delete();

        return redirect()->route('admin.partner-discounts.index')->with('status', 'Diskon kemitraan berhasil dihapus.');
    }

    public function toggle(PartnerDiscount $partnerDiscount)
    {
        $partnerDiscount->update([
            'is_active' => ! $partnerDiscount->is_active,
        ]);

        return back()->with('status', 'Status diskon kemitraan berhasil diubah.');
    }
}
