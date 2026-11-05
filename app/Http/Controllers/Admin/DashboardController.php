<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now();
        $weekStart = $today->copy()->startOfWeek();
        $confirmedBookings = Booking::query()->where('status', 'confirmed');
        $weeklyRevenue = collect(range(0, 6))->map(function (int $dayOffset) use ($weekStart): array {
            $date = $weekStart->copy()->addDays($dayOffset);

            return [
                'label' => $date->format('D'),
                'amount' => (float) Booking::query()
                    ->where('payment_status', 'paid')
                    ->whereBetween('updated_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()])
                    ->sum('amount'),
            ];
        });

        $dashboardMetrics = [
            'total_bookings' => Booking::query()->count(),
            'verified_payment_total' => (float) Booking::query()->where('payment_status', 'paid')->sum('amount'),
            'pending_bookings' => Booking::query()->whereIn('status', ['pending_payment', 'pending_verification'])->count(),
            'confirmed_bookings' => $confirmedBookings->count(),
            'monthly_payment_total' => (float) Booking::query()
                ->where('payment_status', 'paid')
                ->whereBetween('updated_at', [$today->copy()->startOfMonth(), $today->copy()->endOfMonth()])
                ->sum('amount'),
        ];

        $topExperience = $confirmedBookings
            ->select('tour_id')
            ->selectRaw('COUNT(*) as booking_count')
            ->selectRaw('SUM(amount) as payment_total')
            ->with('tour')
            ->groupBy('tour_id')
            ->orderByDesc('booking_count')
            ->first();

        return view('admin.dashboard.index', [
            'dashboardMetrics' => $dashboardMetrics,
            'weeklyRevenue' => $weeklyRevenue,
            'maximumWeeklyRevenue' => max(1, $weeklyRevenue->max('amount')),
            'topExperience' => $topExperience,
        ]);
    }
}
