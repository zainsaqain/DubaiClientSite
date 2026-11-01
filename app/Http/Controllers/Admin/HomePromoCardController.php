<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePromoCard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomePromoCardController extends Controller
{
    public function index(): View
    {
        return view('admin.home.promo-cards.index', ['cards' => HomePromoCard::query()->orderBy('display_order')->paginate(10)]);
    }

    public function create(): View
    {
        return view('admin.home.promo-cards.form', ['card' => new HomePromoCard(['display_order' => (HomePromoCard::max('display_order') ?? 0) + 1])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $card = new HomePromoCard;
        $this->saveCard($request, $card);

        return redirect()->route('admin.home.promo-cards.index')->with('success', 'Promo card created successfully.');
    }

    public function edit(HomePromoCard $promoCard): View
    {
        return view('admin.home.promo-cards.form', ['card' => $promoCard]);
    }

    public function update(Request $request, HomePromoCard $promoCard): RedirectResponse
    {
        $this->saveCard($request, $promoCard);

        return redirect()->route('admin.home.promo-cards.index')->with('success', 'Promo card updated successfully.');
    }

    public function destroy(HomePromoCard $promoCard): RedirectResponse
    {
        if ($promoCard->image && ! str_starts_with($promoCard->image, 'images/')) {
            Storage::disk('public')->delete($promoCard->image);
        }

        $promoCard->delete();

        return redirect()->route('admin.home.promo-cards.index')->with('success', 'Promo card removed successfully.');
    }

    private function saveCard(Request $request, HomePromoCard $card): void
    {
        $data = $request->validate([
            'eyebrow' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'max:600'],
            'button_label' => ['required', 'string', 'max:60'],
            'button_url' => ['required', 'string', 'max:255'],
            'display_order' => ['required', 'integer', 'min:1', 'max:999'],
            'image' => ['nullable', 'image', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($card->image && ! str_starts_with($card->image, 'images/')) {
                Storage::disk('public')->delete($card->image);
            }

            $data['image'] = $request->file('image')->store('home-promo-cards', 'public');
        }

        $card->fill($data)->save();
    }
}
