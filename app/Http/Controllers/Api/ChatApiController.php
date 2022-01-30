<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Chat\Message\Service\BroadcastAwareMessageSendingService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChatMessageStoreRequest;
use App\Model\ChatMessage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        return ChatMessage::with('user:id,username,image_path')->latest()->paginate(8);
    }

    /**
     * @param  ChatMessageStoreRequest  $request
     * @param  BroadcastAwareMessageSendingService  $messageSendService
     * @return array
     */
    public function sendMessage(ChatMessageStoreRequest $request, BroadcastAwareMessageSendingService $messageSendService): array
    {
        $messageSendService->send($request->user(), $request->get('message'));

        return [];
    }
}
