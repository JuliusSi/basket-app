<?php

declare(strict_types=1);

namespace App\Chat\Service;

use App\Events\ChatMessageSent;
use App\Http\Requests\ChatMessageStoreRequest;
use App\Model\ChatMessage;

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

        return [];
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
}
