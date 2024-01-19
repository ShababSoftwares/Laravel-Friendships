<?php

namespace ShababSoftwares\Friendships\Events;

use ShababSoftwares\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Unblocked
{
    use Dispatchable, SerializesModels;

    /**
     * The sender of unblocked friendship request.
     *
     * @var Model
     */
    public $sender;

    /**
     * The recipient of unblocked friendship request.
     *
     * @var Model
     */
    public $recipient;

    /**
     * Create a new unblocked friendship event instance.
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
