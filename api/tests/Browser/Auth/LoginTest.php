<?php

namespace Tests\Browser\Auth;

use Laravel\Dusk\Browser;
use Tests\Browser\Extensions\RouteNamesExtension;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use RouteNamesExtension;

    /** @test **/
    public function userSeeWrongCredentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->routeByName('login'))
                ->type('@l-email-input', 'user@app')
                ->type('@l-password-input', 'wrong-password')
                ->press('@l-login-button')

                ->waitFor('@l-error-message')

                ->assertSeeIn('@l-error-message', trans('auth.wrong_credentials'));
        });
    }

    /** @test **/
    public function userCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->routeByName('login'))
                ->type('@l-email-input', 'user@app')
                ->type('@l-password-input', 'password')
                ->press('@l-login-button')

                ->waitUntilMissing('@l-login-button')

                ->click('@um-user-menu')

                ->waitFor('@um-user-name')
                ->assertSeeIn('@um-user-name', 'user');
        });
    }
}
