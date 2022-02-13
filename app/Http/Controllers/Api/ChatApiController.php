<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Chat\Message\Service\MessageSendingServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatMessageStoreRequest;
use App\Model\ChatMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ChatApiController extends Controller
{
    public function __construct(private MessageSendingServiceInterface $messageSendService)
    {
    }

    public function getMessages(): LengthAwarePaginator
    {
        return ChatMessage::with('user:id,username,image_path')->latest()->paginate(8);
    }

    public function sendMessage(ChatMessageStoreRequest $request): array
    {
        $this->messageSendService->send($request->user(), $request->get('message'));

        return [];
    }
}
