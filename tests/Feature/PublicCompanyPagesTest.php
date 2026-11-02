<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicCompanyPagesTest extends TestCase
{
    public function test_company_information_pages_are_available(): void
    {
        $this->get('/about-us')->assertOk();
        $this->get('/where-to-find-us')->assertOk();
        $this->get('/travel-agent-partners')->assertOk();
        $this->get('/meetings-incentives-events')
            ->assertOk()
            ->assertSee('Meetings, Incentives &amp; Events', false);
        $this->get('/signature-events')
            ->assertOk()
            ->assertSee('Signature Events');
        $this->get('/guidelines')->assertOk()->assertSee('Travel Guidelines');
        $this->get('/cancellation-refund-policy')->assertOk()->assertSee('Cancellation');
        $this->get('/terms-and-conditions')->assertOk()->assertSee('Terms');
    }

    public function test_footer_routes_are_registered(): void
    {
        $this->assertNotNull(route('where-to-find-us', absolute: false));
        $this->assertNotNull(route('travel-agent-partners', absolute: false));
        $this->assertNotNull(route('meetings-incentives-events', absolute: false));
        $this->assertNotNull(route('signature-events', absolute: false));
        $this->assertNotNull(route('guidelines', absolute: false));
        $this->assertNotNull(route('cancellation-refund-policy', absolute: false));
        $this->assertNotNull(route('terms-and-conditions', absolute: false));
    }
}
