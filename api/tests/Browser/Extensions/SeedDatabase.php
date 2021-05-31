<?php

namespace Tests\Browser\Extensions;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

trait SeedDatabase {
    public function runDatabaseMigrations()
    {
        dump('seeding');
        $this->artisan('migrate:fresh --seed');

        $this->app[Kernel::class]->setArtisan(null);

        $this->beforeApplicationDestroyed(function () {
            $this->artisan('migrate:rollback');

            RefreshDatabaseState::$migrated = false;
        });
    }
}
