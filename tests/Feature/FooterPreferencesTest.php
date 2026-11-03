<?php

namespace Tests\Feature;

use Tests\TestCase;

class FooterPreferencesTest extends TestCase
{
    public function test_shared_footer_includes_language_and_currency_preferences(): void
    {
        $footer = view('components.site.footer')->render();

        $this->assertStringContainsString('Change language', $footer);
        $this->assertStringContainsString('Pakistani Rupee', $footer);
        $this->assertStringContainsString('United States Dollar', $footer);
        $this->assertStringContainsString('data-language-option', $footer);
        $this->assertStringContainsString('data-currency-option', $footer);
    }
}
