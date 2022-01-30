<?php

declare(strict_types=1);

namespace App\Chat\Message\Modifier;

use App\Model\User;

interface ModifierInterface
{
    public function modify(string $message, ?User $user = null): string;
}
