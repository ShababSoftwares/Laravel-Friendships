<?php

namespace ShababSoftwares\Friendships;

use Illuminate\Support\ServiceProvider;

class FriendshipsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        if (class_exists('CreateFriendshipsTable') || class_exists('CreateFriendshipsGroupsTable')) {
            return;
        }

        $stub      = realpath(dirname(__DIR__).'/tests/database/migrations/') . '/';
        $target    = database_path('migrations') . '/';

        $this->publishes([
            $stub . '0000_00_00_000000_create_friendships_table.php'        => $target . date('Y_m_d_His', time()) . '_create_friendships_table.php',
            $stub . '0000_00_00_000000_create_friendships_groups_table.php' => $target . date('Y_m_d_His', time() + 1) . '_create_friendships_groups_table.php'
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../tests/config/friendships.php' => config_path('friendships.php'),
        ], 'config');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
