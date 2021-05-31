<?php

namespace Tests\Browser\Auth;

use Laravel\Dusk\Browser;
use Tests\Browser\Extensions\RouteNamesExtension;
use Tests\Browser\Extensions\UserAssertions;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use RouteNamesExtension, UserAssertions;

    /**
     * @test
     * @group auth
     * @group login
     */
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

    /**
     * @test
     * @group auth
     * @group login
     */
    public function userCanLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit($this->routeByName('home'))
                ->click('@gm-guest-menu')
                ->waitFor('@gm-login-link')
                ->click('@gm-login-link')
                ->waitFor('@l-email-input')

                ->type('@l-email-input', 'user@app')
                ->type('@l-password-input', 'password')
                ->press('@l-login-button')

                ->waitUntilMissing('@l-login-button');

            $this->assertThatUserLoggedIn($browser, 'user');
        });
    }
}
