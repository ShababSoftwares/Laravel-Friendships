<?php

namespace ShababSoftwares\Friendships\Events;

use ShababSoftwares\Friendships\Traits\Friendable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Cancelled
{
    use Dispatchable, SerializesModels;

    /**
     * The sender of cancelled friendship request.
     *
     * @var Model
     */
    public $sender;

    /**
     * The recipient of cancelled friendship request.
     *
     * @var Model
     */
    public $recipient;

    /**
     * Create a new cancelled friendship event instance.
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
