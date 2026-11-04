<?php

namespace Tests\Feature\Auth;

use App\Mail\NewCustomerRegistered;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        Mail::fake();
        $administrator = User::factory()->create(['is_admin' => true]);

        $response = $this->post('/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'date_of_birth' => '1992-04-10',
            'country_of_residence' => 'Pakistan',
            'phone_country_code' => '+92',
            'phone_number' => '3001234567',
            'email' => 'test@example.com',
            'email_confirmation' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('account.dashboard', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'first_name' => 'Test',
            'last_name' => 'User',
            'country_of_residence' => 'Pakistan',
            'is_admin' => false,
        ]);
        Mail::assertSent(NewCustomerRegistered::class, 2);
        Mail::assertSent(NewCustomerRegistered::class, fn (NewCustomerRegistered $mail) => $mail->hasTo('test@example.com') && ! $mail->forAdmin);
        Mail::assertSent(NewCustomerRegistered::class, fn (NewCustomerRegistered $mail) => $mail->hasTo($administrator->email) && $mail->forAdmin);
    }
}
