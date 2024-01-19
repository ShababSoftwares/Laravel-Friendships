<?php

namespace ShababSoftwares\Friendships\Events;

use ShababSoftwares\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Accepted
{
    use Dispatchable, SerializesModels;

    /**
     * The sender of accepted friendship request.
     *
     * @var Model
     */
    public $sender;

    /**
     * The recipient of accepted friendship request.
     *
     * @var Model
     */
    public $recipient;

    /**
     * Create a new accepted friendship event instance.
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
