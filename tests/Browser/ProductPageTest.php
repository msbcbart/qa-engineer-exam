<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Artisan;
use App\Models\Admin;

class ProductPageTest extends DuskTestCase
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
    
    public function test_product_page_ui_elements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                // Navigation bar visibility
                ->assertVisible('nav.main-header.navbar')
                ->assertVisible('i.fas.fa-bars') 

                // Sidebar menu items
                ->assertVisible('aside.main-sidebar')
                ->assertSee('Products') // Header
                ->assertSee('List') // Menu item
                ->assertSee('Create') // Menu item
                ->assertSee('Videos') // Menu item
                ->assertSee('Logout') // Menu item

                // Content header and button
                ->assertVisible('div.content-header')
                ->assertSee('Products') // Page title
                ->assertVisible('a.btn.btn-primary.btn-round.float-right') // Create button
                ->assertSee('Create') // Button text

                // Product table visibility
                ->assertVisible('table')
                ->assertSee('Name') // Table header
                ->assertSee('Category') // Table header
                ->assertSee('Description') // Table header
                ->assertVisible('td') // Table data cells
                ->assertSee('Electonics') // Category
                ->assertSee('Clothing') // Category
                ->assertSee('Sports & Outdoors') // Category

                // Pagination
                ->assertVisible('nav[aria-label="Page navigation"]')
                ->assertSee('1')
                ->assertSee('2')
                ->assertSee('»'); // Next button
        });
    }
    
    
    public function test_create_button_redirected_to_form(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/product')
                    ->click('.btn.btn-primary.btn-round.float-right')
                    ->waitForLocation('/product/form')
                    ->assertPathIs('/product/form')
                    ->assertVisible('nav.main-header.navbar') // Verify the navigation bar
                    ->assertSee('Product Create') // Verify the title
                    ->assertSee('Step 1 / 3') // Verify the step indicator text
                    ->assertVisible('input.form-control') // Verify the name input field
                    ->assertVisible('select.form-control') // Verify the category dropdown
                    ->assertVisible('.ck-editor__editable') // Verify the rich text editor
                    ->assertVisible('.btn.btn-dark'); // Verify the Next button
        });
    }
}
