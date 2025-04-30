<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;


use Tests\DuskTestCase;

class UncompletedOrdersTest extends DuskTestCase
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

    /* Log in to the application.*/
    public function testUncopleted()
    {
        $this->browse(function (Browser $browser) {
            $browser->click('#UncompletedOrders')->assertSee("Uncompleted Orders");
        });
    }

}
