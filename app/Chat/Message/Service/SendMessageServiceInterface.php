<?php

declare(strict_types=1);

namespace App\Chat\Message\Service;

use App\Model\User;

interface SendMessageServiceInterface
{
    public function send(User $user, string $message);
}
