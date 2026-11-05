<?php

namespace App\Providers;

use App\Models\BankTransferPayment;
use App\Models\TourCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('components.site.header', function ($view): void {
            $navigationCategories = TourCategory::query()
                ->where('is_active', true)
                ->with([
                    'subcategories' => fn ($query) => $query
                        ->where('is_active', true)
                        ->withCount(['tours' => fn (Builder $tourQuery): Builder => $tourQuery->public()])
                        ->with(['tours' => fn ($tourQuery) => $tourQuery
                            ->public()
                            ->with('images')
                            ->orderByDesc('is_featured')
                            ->orderBy('display_order')
                            ->limit(1)])
                        ->orderBy('display_order'),
                    'tours' => fn ($query) => $query
                        ->public()
                        ->with('images')
                        ->orderByDesc('is_featured')
                        ->orderBy('display_order')
                        ->limit(5),
                ])
                ->orderBy('display_order')
                ->get()
                ->unique(static fn (TourCategory $category): string => Str::lower(trim($category->name)))
                ->values();

            $view->with('navigationCategories', $navigationCategories);
        });

        View::composer('admin.partials.sidebar', function ($view): void {
            $pendingBankTransferPaymentCount = BankTransferPayment::query()
                ->whereIn('status', ['pending_payment', 'pending_verification'])
                ->count();

            $view->with('pendingBankTransferPaymentCount', $pendingBankTransferPaymentCount);
        });
    }
}
