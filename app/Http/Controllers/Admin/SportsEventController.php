<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SportsEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SportsEventController extends Controller
{
    public function index(): View
    {
        return view('admin.sports-events.index', [
            'events' => SportsEvent::query()->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.sports-events.form', [
            'event' => new SportsEvent,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $event = new SportsEvent;
        $this->saveEvent($request, $event);

        return redirect()->route('admin.sports-events.index')->with('success', 'Sports event created successfully.');
    }

    public function edit(SportsEvent $sportsEvent): View
    {
        return view('admin.sports-events.form', [
            'event' => $sportsEvent,
        ]);
    }

    public function update(Request $request, SportsEvent $sportsEvent): RedirectResponse
    {
        $this->saveEvent($request, $sportsEvent);

        return redirect()->route('admin.sports-events.index')->with('success', 'Sports event updated successfully.');
    }

    public function destroy(SportsEvent $sportsEvent): RedirectResponse
    {
        if ($sportsEvent->image && ! str_starts_with($sportsEvent->image, 'images/')) {
            Storage::disk('public')->delete($sportsEvent->image);
        }

        $sportsEvent->delete();

        return redirect()->route('admin.sports-events.index')->with('success', 'Sports event removed successfully.');
    }

    private function saveEvent(Request $request, SportsEvent $event): void
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'event_type' => ['required', 'string', 'max:80'],
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
            if ($event->image && ! str_starts_with($event->image, 'images/')) {
                Storage::disk('public')->delete($event->image);
            }

            $data['image'] = $request->file('image')->store('sports-events', 'public');
        }

        $event->fill($data)->save();
    }
}
