<?php

declare(strict_types=1);

namespace App\Providers;

use App\Chat\Message\Modifier\EmojiModifier;
use App\Chat\Message\Service\BaseMessageSendingService;
use App\Chat\Message\Service\BroadcastAwareMessageSendingService;
use App\Chat\Message\Service\MessageSendingServiceInterface;
use App\Http\Controllers\Api\ChatApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            'chat.message.modifier.collection',
            function ($app) {
                return new Collection(
                    [
                        $app->make(EmojiModifier::class),
                    ]
                );
            }
        );

        $this->app->bind(BaseMessageSendingService::class, function ($app) {
            return new BaseMessageSendingService($app->make('chat.message.modifier.collection'));
        });

        $this->app
            ->when(ChatApiController::class)
            ->needs(MessageSendingServiceInterface::class)
            ->give(BroadcastAwareMessageSendingService::class);
    }
}
