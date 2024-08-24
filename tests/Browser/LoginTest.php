<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Admin;

class LoginTest extends DuskTestCase
{
    public function test_login_with_valid_credentials(): void
    {
        $admin = Admin::first();
        
        $this->browse(function (Browser $browser) use ($admin) {
            $browser->visit('/login')
                    ->type('email', $admin->email)
                    ->type('password', 'password')
                    ->press('Sign In')
                    ->assertPathIs('/product');
        });
    }
}
