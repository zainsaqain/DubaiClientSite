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
    }

    public function test_footer_routes_are_registered(): void
    {
        $this->assertNotNull(route('where-to-find-us', absolute: false));
        $this->assertNotNull(route('travel-agent-partners', absolute: false));
    }
}
