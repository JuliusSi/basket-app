<?php

declare(strict_types=1);

namespace App\Providers;

use App\Chat\Listener\NotifyAboutNewUser;
use App\Chat\Message\Modifier\EmojiModifier;
use App\Chat\Message\Service\MessageService;
use App\Chat\Message\Service\BroadcastMessageService;
use App\Chat\Message\Service\MessageSender;
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

        $this->app->bind(MessageService::class, function ($app) {
            return new MessageService($app->make('chat.message.modifier.collection'));
        });

        $this->app
            ->when(ChatApiController::class)
            ->needs(MessageSender::class)
            ->give(BroadcastMessageService::class);

        $this->app
            ->when(NotifyAboutNewUser::class)
            ->needs(MessageSender::class)
            ->give(BroadcastMessageService::class);
    }
}
