<?php

namespace ShababSoftwares\Friendships\Events;

use ShababSoftwares\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Blocked
{
    use Dispatchable, SerializesModels;

    /**
     * The sender of blocked friendship request.
     *
     * @var Model
     */
    public $sender;

    /**
     * The recipient of blocked friendship request.
     *
     * @var Model
     */
    public $recipient;

    /**
     * Create a new blocked friendship event instance.
     *
     * @param Model|Friendable $sender
     * @param Model $recipient
     */
    public function __construct(Model $sender, Model $recipient)
    {
        $this->sender = $sender;
        $this->recipient = $recipient;
    }
}
