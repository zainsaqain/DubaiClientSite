<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TransferController extends Controller
{
    public function index(): View
    {
        return view('admin.transfers.index', ['transfers' => Transfer::query()->latest()->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.transfers.form', ['transfer' => new Transfer]);
    }

    public function store(Request $request): RedirectResponse
    {
        $transfer = new Transfer;
        $this->saveTransfer($request, $transfer);

        return redirect()->route('admin.transfers.index')->with('success', 'Transfer created successfully.');
    }

    public function edit(Transfer $transfer): View
    {
        return view('admin.transfers.form', compact('transfer'));
    }

    public function update(Request $request, Transfer $transfer): RedirectResponse
    {
        $this->saveTransfer($request, $transfer);

        return redirect()->route('admin.transfers.index')->with('success', 'Transfer updated successfully.');
    }

    public function destroy(Transfer $transfer): RedirectResponse
    {
        if ($transfer->image && ! str_starts_with($transfer->image, 'images/')) {
            Storage::disk('public')->delete($transfer->image);
        }

        $transfer->delete();

        return redirect()->route('admin.transfers.index')->with('success', 'Transfer removed successfully.');
    }

    private function saveTransfer(Request $request, Transfer $transfer): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'transfer_type' => ['required', 'string', 'max:80'],
            'description' => ['required', 'string', 'max:1200'],
            'location' => ['required', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'max:4096'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($transfer->image && ! str_starts_with($transfer->image, 'images/')) {
                Storage::disk('public')->delete($transfer->image);
            }

            $data['image'] = $request->file('image')->store('transfers', 'public');
        }

        $transfer->fill($data)->save();
    }
}
