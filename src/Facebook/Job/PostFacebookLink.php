<?php

declare(strict_types=1);

namespace Src\Facebook\Job;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Repository\FacebookLinkRepository;

class PostFacebookLink implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 2;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $backoff = 30;

    public function __construct(private readonly FacebookLinkPostRequestBody $linkPostRequestBody)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function handle(FacebookLinkRepository $facebookLinkRepository): void
    {
        $facebookLinkRepository->post($this->linkPostRequestBody);
    }

    public function tags(): array
    {
        return ['post_facebook_link'];
    }
}
