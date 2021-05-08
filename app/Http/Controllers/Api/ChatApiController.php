<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;


use App\Chat\Service\MessageSendService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatMessageSendRequest;
use App\Model\ChatMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

/**
 * Class ChatApiController
 * @package App\Http\Controllers\Api
 */
class ChatApiController extends Controller
{
    /**
     * @return LengthAwarePaginator
     */
    public function getMessages(): LengthAwarePaginator
    {
        return ChatMessage::with('user')->latest()->paginate(8);
    }

    /**
     * @param  ChatMessageSendRequest  $request
     * @param  MessageSendService  $messageSendService
     * @return array
     */
    public function sendMessage(ChatMessageSendRequest $request, MessageSendService $messageSendService): array
    {
        return $messageSendService->send($request);
    }
}
