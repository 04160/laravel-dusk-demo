<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class BaseTest extends DuskTestCase
{
    /**
     * See links in home page
     */
    public function testHomePageLinks()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSeeLink('Login')
                ->assertSeeLink('Register');
        });
    }

    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'user@example.com')
                ->type('password', 'useruser')
                ->click('[type="submit"]')
                ->assertSee('You are logged in!');
        });
    }

    public function testOpenValueList()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(1)
                ->visit('/list')
                ->assertSee('Value list');
        });
    }
}
