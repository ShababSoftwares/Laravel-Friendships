<?php

namespace Tests;

use ShababSoftwares\Friendships\Events\Accepted;
use ShababSoftwares\Friendships\Events\Blocked;
use ShababSoftwares\Friendships\Events\Cancelled;
use ShababSoftwares\Friendships\Events\Denied;
use ShababSoftwares\Friendships\Events\Sent;
use ShababSoftwares\Friendships\Events\Unblocked;
use Illuminate\Support\Facades\Event;
use Orchestra\Testbench\TestCase;

class FriendshipsEventsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations(['--database' => 'testing']);
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--path' => realpath(dirname(__DIR__).'/tests/database/migrations'),
        ]);
        $this->withFactories(realpath(dirname(__DIR__).'/database/factories'));
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('friendships.tables.fr_groups_pivot', 'user_friendship_groups');
        $app['config']->set('friendships.tables.fr_pivot', 'friendships');
        $app['config']->set('friendships.groups.acquaintances', 0);
        $app['config']->set('friendships.groups.close_friends', 1);
        $app['config']->set('friendships.groups.family', 2);
    }

    /** @test */
    public function friend_request_is_sent()
    {
        Event::fake();
        $sender    = createUser();
        $recipient = createUser();

        $sender->befriend($recipient);

        Event::assertDispatched(Sent::class, function ($event) use ($sender, $recipient) {
            return $event->sender->id === $sender->id && $event->recipient->id === $recipient->id;
        });
    }

    /** @test */
    public function friend_request_is_accepted()
    {
        Event::fake();
        $sender    = createUser();
        $recipient = createUser();

        $recipient->befriend($sender);
        $sender->acceptFriendRequest($recipient);

        Event::assertDispatched(Accepted::class, function ($event) use ($sender, $recipient) {
            return $event->sender->id === $sender->id && $event->recipient->id === $recipient->id;
        });
    }

    /** @test */
    public function friend_request_is_denied()
    {
        Event::fake();
        $sender    = createUser();
        $recipient = createUser();

        $recipient->befriend($sender);

        $sender->denyFriendRequest($recipient);
        Event::assertDispatched(Denied::class, function ($event) use ($sender, $recipient) {
            return $event->sender->id === $sender->id && $event->recipient->id === $recipient->id;
        });

    }

    /** @test */
    public function friend_is_blocked()
    {
        Event::fake();
        $sender    = createUser();
        $recipient = createUser();

        $recipient->befriend($sender);
        $sender->acceptFriendRequest($recipient);
        $sender->blockFriend($recipient);
        Event::assertDispatched(Blocked::class, function ($event) use ($sender, $recipient) {
            return $event->sender->id === $sender->id && $event->recipient->id === $recipient->id;
        });
    }

    /** @test */
    public function friend_is_unblocked()
    {
        Event::fake();
        $sender    = createUser();
        $recipient = createUser();

        $recipient->befriend($sender);
        $sender->acceptFriendRequest($recipient);
        $sender->blockFriend($recipient);
        $sender->unblockFriend($recipient);
        Event::assertDispatched(Unblocked::class, function ($event) use ($sender, $recipient) {
            return $event->sender->id === $sender->id && $event->recipient->id === $recipient->id;
        });
    }

    /** @test */
    public function friendship_is_cancelled()
    {
        Event::fake();
        $sender    = createUser();
        $recipient = createUser();
        $recipient->befriend($sender);
        $sender->acceptFriendRequest($recipient);
        $sender->unfriend($recipient);
        Event::assertDispatched(Cancelled::class, function ($event) use ($sender, $recipient) {
            return $event->sender->id === $sender->id && $event->recipient->id === $recipient->id;
        });
    }
}
