<?php

namespace App\Console\Commands;
use App\Service\FacebookLinkPostService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class FacebookPostCommand
 * @package App\Console\Commands
 */
class FacebookPostCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'facebook:addPost';

    /**
     * @var string
     */
    protected $description = 'Adds post to Facebook page.';

    /**
     * @var FacebookLinkPostService
     */
    private FacebookLinkPostService $facebookLinkPostService;

    /**
     * FacebookPostCommand constructor.
     * @param  FacebookLinkPostService  $facebookLinkPostService
     */
    public function __construct(FacebookLinkPostService $facebookLinkPostService)
    {
        parent::__construct();
        $this->facebookLinkPostService = $facebookLinkPostService;
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $result = $this->facebookLinkPostService->post();
        if ($result) {
            Log::info(sprintf('Post successfully posted to Facebook. Post id: %s', $result->getId()));

            return true;
        }

        return false;
    }
}
