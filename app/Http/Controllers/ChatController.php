<?php

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
     * @var MessageSendService
     */
    private MessageSendService $messageSendService;

    /**
     * ChatController constructor.
     * @param  MessageSendService  $messageSendService
     */
    public function __construct(MessageSendService $messageSendService)
    {
        $this->messageSendService = $messageSendService;
    }

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
     * @return array
     */
    public function sendMessage(Request $request): array
    {
        return $this->messageSendService->send($request);
    }
}
