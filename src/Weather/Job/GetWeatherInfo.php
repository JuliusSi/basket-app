<?php

declare(strict_types=1);

namespace Src\Weather\Job;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Src\Weather\Repository\CachedWeatherRepository;

class GetWeatherInfo implements ShouldQueue
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

    public function __construct(public string $placeCode)
    {
    }

    /**
     * @throws GuzzleException
     */
    public function handle(CachedWeatherRepository $repository): void
    {
        Log::channel('queue')->info('Job started.', ['class' => __CLASS__, 'place_code' => $this->placeCode]);
        $repository->find($this->placeCode);
        Log::channel('queue')->info('Job finished.', ['class' => __CLASS__, 'place_code' => $this->placeCode]);
    }

    public function tags(): array
    {
        return ['get_weather_info', 'place_code:'.$this->placeCode];
    }
}
