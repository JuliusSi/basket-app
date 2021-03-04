<?php

namespace App\Chat\Service;

use App\Events\ChatMessageSent;
use App\Model\ChatMessage;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
     * @param  Request  $request
     * @return array
     */
    public function send(Request $request): array
    {
        $user = Auth::user();
        if (!$user instanceof User) {
            return [];
        }
        $errors = $this->validate($request);
        if ($errors) {
            return $errors;
        }
        $modifiedMessage = $this->emojiAppendService->appendEmojiList($request->get('message'));
        $message = $this->saveMessage($user, $modifiedMessage);
        broadcast(new ChatMessageSent($user, $message))->toOthers();

        return [];
    }

    /**
     * @param  Request  $request
     * @return array
     */
    private function validate(Request $request): array
    {
        $validator = Validator::make($request->all(),
            [
                'message' => 'required|min:2|max:500|string|not_regex:/([%\$#\*<>]+)/',
            ]);
        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        return [];
    }

    /**
     * @param  User  $user
     * @param  string  $content
     * @return ChatMessage
     */
    private function saveMessage(User $user, string $content): ChatMessage
    {
        return $user->chatMessages()->create([
            'message' => $content,
        ]);
    }
}
