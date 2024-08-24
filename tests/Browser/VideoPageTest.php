<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Admin;

class VideoPageTest extends DuskTestCase
{
    // Login
    public function test_login_as_admin(): void
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
    
    public function test_video_page_ui_elements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/videos')
                ->pause(2000) 
                // Navigation bar visibility
                ->assertVisible('nav.main-header.navbar')
                ->assertVisible('i.fas.fa-bars') 
                
                // Sidebar menu items
                ->assertVisible('aside.main-sidebar')
                ->assertSee('Products', 'li.nav-header.text-uppercase')
                ->assertSee('List', 'a[href="http://localhost:8000/product"]')
                ->assertSee('Create', 'a[href="http://localhost:8000/product/form"]')
                ->assertSee('Videos', 'a.nav-link.active')
                ->assertSee('Logout', 'a.nav-link')
                
                // Content/Video visibility
                ->assertVisible('.video-js');
        });
    }
}
