<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Chat\Service\MessageSendService;
use App\Model\ChatMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

/**
 * Class ChatController
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    /**
     * @return Collection
     */
    public function fetchMessages(): Collection
    {
        $messages = ChatMessage::with('user')->latest()->take(10)->get();

        return $messages->reverse()->values();
    }

    /**
     * @param  Request  $request
     * @param  MessageSendService  $messageSendService
     * @return array
     */
    public function sendMessage(Request $request, MessageSendService $messageSendService): array
    {
        return $messageSendService->send($request);
    }
}
