<?php

declare(strict_types=1);

namespace App\Notifier\Collection;

use App\Notifier\Model\Notification;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Client\Response\Response;
use Src\Facebook\Repository\FacebookLinkRepository;

class FacebookPageNotifier implements NotifierInterface
{
    private FacebookLinkRepository $facebookLinkRepository;

    public function __construct(
        FacebookLinkRepository $facebookLinkRepository
    ) {
        $this->facebookLinkRepository = $facebookLinkRepository;
    }

    /**
     * @param Notification[] $notifications
     */
    public function notify(array $notifications): void
    {
        foreach ($notifications as $notification) {
            $this->postLink($this->buildRequest($notification));
        }
    }

    private function buildRequest(Notification $notification): FacebookLinkPostRequestBody
    {
        $request = new FacebookLinkPostRequestBody();
        $request->setLink($notification->getImageUrl());
        $request->setMessage($notification->getContent());

        return $request;
    }

    private function postLink(FacebookLinkPostRequestBody $request): ?Response
    {
        try {
            Log::info(sprintf('Trying to post message: %s', $request->getMessage()));
            $result = $this->facebookLinkRepository->post($request);
            Log::info(sprintf('Post successfully posted to Facebook. Post id: %s', $result->getId()));

            return $result;
        } catch (GuzzleException $exception) {
            Log::warning(sprintf('Can not post facebook link. %s', $exception->getMessage()));

            return null;
        }
    }
}
