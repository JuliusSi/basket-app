<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

class UserNotificationApiController extends Controller
{
    public function getNotifications(): LengthAwarePaginator
    {
        $notifications = auth()
            ->user()
            ->userNotifications()
            ->latest()
            ->orderByRaw("FIELD(status , 'new') DESC")
            ->paginate(5)
        ;

        $items = $notifications->items();

        foreach ($items as $notification) {
            if (UserNotification::STATUS_NEW !== $notification->status) {
                continue;
            }

            $createdAt = Carbon::createFromFormat('Y-m-d H:i:s', $notification->created_at);
            if ($createdAt->isPast()) {
                $notification->update([
                    'status' => UserNotification::STATUS_READ,
                ]);
            }
        }

        return $notifications;
    }
}
