<?php

declare(strict_types=1);

namespace Tests\Feature\App\Chat;

use App\Model\ChatMessage;
use App\Model\User;
use Tests\TestCase;

class PostCommentTest extends TestCase
{
    public function testPostComment(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user,'api');
        $message = 'This is test message';
        $data = ['message' => $message];
        $response = $this->postJson('api/comment', $data);

        $this->assertDatabaseHas('chat_message', ['message' => $message]);
    }
}
