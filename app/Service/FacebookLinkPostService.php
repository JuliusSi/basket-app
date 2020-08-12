<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Src\Facebook\Client\Request\FacebookLinkPostRequestBody;
use Src\Facebook\Client\Response\Response;
use Src\Facebook\Repository\FacebookLinkRepository;

/**
 * Class FacebookLinkPostService
 * @package App\Service
 */
class FacebookLinkPostService
{
    private const GOOD_WEATHER_GIF_URL = 'https://i.gifer.com/TtIr.gif';
    private const BAD_WEATHER_GIF_URL = 'https://i1.wp.com/watsonssportstake.com/wp-content/uploads/2018/06/Lebron-James-reacting-to-a-call.gif?fit=500%2C288&ssl=1';

    /**
     * @var WeatherForBasketBallWarningService
     */
    private WeatherForBasketBallWarningService $warningService;

    /**
     * @var FacebookLinkRepository
     */
    private FacebookLinkRepository $facebookLinkRepository;

    /**
     * FacebookLinkPostService constructor.
     * @param  WeatherForBasketBallWarningService  $warningService
     * @param  FacebookLinkRepository  $facebookLinkRepository
     */
    public function __construct(
        WeatherForBasketBallWarningService $warningService,
        FacebookLinkRepository $facebookLinkRepository
    ) {
        $this->warningService = $warningService;
        $this->facebookLinkRepository = $facebookLinkRepository;
    }

    /**
     * @return Response|null
     */
    public function post(): ?Response
    {
        $request = $this->getRequest();

        return $this->postLink($request);
    }

    /**
     * @return FacebookLinkPostRequestBody
     */
    private function getRequest(): FacebookLinkPostRequestBody
    {
        $warnings = $this->warningService->getWarningMessages();
        if (!$warnings) {
            return $this->buildRequest(__('weather-rules.success'), self::GOOD_WEATHER_GIF_URL);
        }

        $message = implode(',', $warnings);

        return $this->buildRequest($message, self::BAD_WEATHER_GIF_URL);
    }

    /**
     * @param  string  $message
     * @param  string  $link
     * @return FacebookLinkPostRequestBody
     */
    private function buildRequest(string $message, string $link): FacebookLinkPostRequestBody
    {
        $request = new FacebookLinkPostRequestBody();
        $request->setLink($link);
        $request->setMessage($message);

        return $request;
    }

    /**
     * @param  FacebookLinkPostRequestBody  $request
     * @return Response|null
     */
    private function postLink(FacebookLinkPostRequestBody $request): ?Response
    {
        try {
            Log::info(sprintf('Trying to post message: %s', $request->getMessage()));
            return $this->facebookLinkRepository->post($request);
        } catch (GuzzleException $exception) {
            Log::warning(sprintf('Can not post facebook link. %s', $exception->getMessage()));
            return null;
        }
    }
}
