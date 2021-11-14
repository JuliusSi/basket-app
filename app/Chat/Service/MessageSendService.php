<?php

declare(strict_types=1);

namespace App\Chat\Service;

use App\Events\ChatMessageSent;
use App\Http\Requests\ChatMessageStoreRequest;
use App\Model\ChatMessage;
use Carbon\Carbon;
use Core\Logger\Event\ActionDone;
use Core\Logger\Model\Log;

/**
 * Class MessageSendService
 * @package App\Chat\Service
 */
class MessageSendService
{
    /**
     * @var EmojiAppendService
     */
    private EmojiAppendService $emojiAppendService;

    /**
     * MessageSendService constructor.
     * @param  EmojiAppendService  $emojiAppendService
     */
    public function __construct(EmojiAppendService $emojiAppendService)
    {
        $this->emojiAppendService = $emojiAppendService;
    }

    /**
     * @param  ChatMessageStoreRequest  $request
     * @return array
     */
    public function send(ChatMessageStoreRequest $request): array
    {
        $message = $this->saveMessage($this->addEmojis($request->get('message')));
        broadcast(new ChatMessageSent(auth()->user(), $message))->toOthers();
        $this->createLogMessageIfNeeded();

        return [];
    }

    private function createLogMessageIfNeeded(): void
    {
        $test = $this->getUserTodayMessagesCount();
        if ($this->getUserTodayMessagesCount() > 1) {
            return;
        }

        event(new ActionDone($this->getActionLog()));
    }

    private function getUserTodayMessagesCount(): int
    {
        return ChatMessage::where('user_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->count();
    }

    /**
     * @param  string  $message
     * @return string
     */
    private function addEmojis(string $message)
    {
        return $this->emojiAppendService->appendEmojiList($message);
    }

    /**
     * @param  string  $content
     * @return ChatMessage
     */
    private function saveMessage(string $content): ChatMessage
    {
        return auth()->user()->chatMessages()->create([
            'message' => $content,
        ]);
    }

    private function getActionLog(): Log
    {
        $message = 'Vartotojas {username} parašė savo pirmąjį komentą šiandien';
        $context = [
            'username' => auth()->user()->username,
        ];

        return Log::create($message, $context);
    }
}
