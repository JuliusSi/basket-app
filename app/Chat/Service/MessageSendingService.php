<?php

declare(strict_types=1);

namespace App\Chat\Service;

use App\Events\ChatMessageSent;
use App\Model\ChatMessage;
use App\Model\User;
use Carbon\Carbon;
use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;

class MessageSendingService
{
    public function __construct(private EmojiAppendService $emojiAppendService)
    {
    }

    public function send(User $user, string $message): void
    {
        $messageModel = $this->saveMessage($user, $this->addEmojis($message));
        broadcast(new ChatMessageSent($user, $messageModel))->toOthers();
        $this->createLogMessageIfNeeded($user);
    }

    private function createLogMessageIfNeeded(User $user): void
    {
        if ($this->getUserTodayMessagesCount($user) > 1) {
            return;
        }

        event(new ActionDone($this->getActionLog($user)));
    }

    private function getUserTodayMessagesCount(User $user): int
    {
        return $user->chatMessages()->whereDate('created_at', Carbon::today())->count();
    }

    private function addEmojis(string $message): string
    {
        return $this->emojiAppendService->appendEmojiList($message);
    }

    private function saveMessage(User $user, string $message): ChatMessage
    {
        return $user->chatMessages()->create([
            'message' => $message,
        ]);
    }

    private function getActionLog(User $user): Log
    {
        $message = __(
            'main.logs.user_first_chat_message',
            ['username' => $user->getAttribute('username')]
        );

        return Log::create($message);
    }
}
