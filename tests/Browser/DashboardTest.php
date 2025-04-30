<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

// test comment
use Tests\DuskTestCase;

class DashboardTest extends DuskTestCase
{
    /**
     * Log in to the application.
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://wasla-jo.laravel.cloud/admin/login')
                ->type('email', 'dev@wasla.com') // Type your email
                ->type('password', 'wasla2@25')      // Type your password
                ->press('#login-button')                           // Press the login button
                ->waitForLocation('/dashboard');
        });
    }

    /**
     * Test Dashboard
     */

    public function testDashboard()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point

            // Click on the "Uncompleted Orders" link/button
            $browser
                ->assertSee('Dashboard')
                ->assertSee('Update Data')
                ->waitFor('.card-body')  // Wait for the cards to load

                // Check that "Total Orders Today" label exists
                ->assertSeeIn('.card-label', 'TOTAL ORDERS TODAY')

                // Check that "Active Orders" label exists
                ->assertSee('ACTIVE ORDERS')
                ->assertSee('COMPLETED ORDERS')
                ->assertSee('ACTIVE ORDERS')
                ->assertSee('COMPLETED ORDERS THIS YEAR');
        });
    }

    /**
     * Test side bar on the dashboard.
     */
    public function testSideBar()
    {
        $this->browse(function (Browser $browser) {
            // We are already logged in at this point
            $browser
                ->waitFor('.sidebar')
                ->assertSee('Uncompleted Orders')
                ->assertSee('Advertising')
                ->assertSee('Admins');
        });
    }
}
