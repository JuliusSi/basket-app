<?php

declare(strict_types=1);

namespace App\Events;

use App\Model\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class ChatMessageSent
 * @package App\Events
 */
class ChatMessageSent implements ShouldBroadcast, ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * User that sent the message
     *
     * @var Authenticatable
     */
    public Authenticatable $user;

    /**
     * Message details
     *
     * @var ChatMessage
     */
    public $message;

    /**
     * Create a new event instance.
     *
     * @param  Authenticatable  $user
     * @param  ChatMessage  $message
     */
    public function __construct(Authenticatable $user, ChatMessage $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat');
    }
}
