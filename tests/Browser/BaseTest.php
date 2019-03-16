<?php

namespace Tests\Browser;

use App\Models\Value;
use Facebook\WebDriver\Exception\NoSuchElementException;
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

    public function testCreateNewValue()
    {
        $random_input = uniqid();
        $this->browse(function (Browser $browser) use ($random_input) {
            $browser->loginAs(1)
                ->visit('/list')
                ->type('#create_value [name="value"]', $random_input)
                ->click('#create_value [type="submit"]')
                ->assertInputValue('.edit_value input[value="' . $random_input . '"]', $random_input);
        });
    }

    public function testDeleteValue()
    {
        $random_input = uniqid();
        $deletable_value = Value::create(['name' => $random_input]);
        $delete_url = route('values.delete', ['value_id' => $deletable_value]);
        $this->browse(function (Browser $browser) use ($random_input, $delete_url) {
            $browser->loginAs(1)
                ->visit('/list')
                ->assertInputValue('.edit_value input[value="' . $random_input . '"]', $random_input)
                ->click('.delete_value[action="' . $delete_url . '"] [type="submit"]');

            try {
                $element = $browser->element('.edit_value input[value="' . $random_input . '"]');
                self::assertEmpty($element);
            } catch (NoSuchElementException $e) {
            }
        });

        $value = Value::where('name', $random_input)->first();

        self::assertEmpty($value);
    }
}
