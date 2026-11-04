<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankTransferSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BankTransferSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.bank-transfer.settings', ['setting' => BankTransferSetting::query()->first() ?? new BankTransferSetting(['bank_name' => 'Emirates NBD', 'currency' => 'AED'])]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'bank_name' => ['required', 'string', 'max:120'],
            'account_holder_name' => ['required', 'string', 'max:160'],
            'iban' => ['required', 'string', 'max:64'],
            'account_number' => ['nullable', 'string', 'max:64'],
            'swift_bic' => ['nullable', 'string', 'max:32'],
            'currency' => ['required', 'string', 'size:3'],
            'payment_instructions' => ['nullable', 'string', 'max:3000'],
        ]);
        $data['is_enabled'] = $request->boolean('is_enabled');

        BankTransferSetting::query()->firstOrNew()->fill($data)->save();

        return back()->with('success', 'Bank transfer settings saved successfully.');
    }

    public function destroy(): RedirectResponse
    {
        BankTransferSetting::query()->first()?->delete();

        return redirect()->route('admin.bank-transfer-settings.edit')->with('success', 'Bank transfer details removed and checkout has been disabled.');
    }
}
