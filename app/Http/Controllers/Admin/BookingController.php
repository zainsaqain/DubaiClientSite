<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::query()
            ->where('status', 'confirmed')
            ->with(['user', 'tour', 'bankTransferPayment'])
            ->latest('updated_at')
            ->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }
}
