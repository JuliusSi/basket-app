<?php

namespace Tests\Unit\Notifier\Service;

use App\Notifier\Model\Notification;
use App\Notifier\Service\RadiationInfoNotificationService;
use App\RadiationChecker\Model\RadiationInfo;
use App\RadiationChecker\Service\RadiationInfoService;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Translation\Translator;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class RadiationInfoNotificationServiceTest
 * @package Tests\Unit\Notifier\Service
 */
class RadiationInfoNotificationServiceTest extends TestCase
{
    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $cases = [];

        /**
         * CASE 0,
         *
         * SCENARIO: radiation info service returns radiation info with risky status
         *
         * ACTION: build notification
         */
        $radiationInfo = new RadiationInfo();
        $radiationInfo->setStatus(RadiationInfo::STATUS_HIGH);
        $radiationInfo->setRadiationBackground('0.3');
        $radiationInfo->setUpdatedAt('2020-01-01 00:00');
        $serviceMock = Mockery::mock(RadiationInfoService::class);
        $serviceMock->shouldReceive('getRadiationInfo')->andReturn($radiationInfo);
        $translatorMock = Mockery::mock(Translator::class);
        $translatorMock->shouldReceive('get')->andReturn('translation');
        $configRepositoryMock = Mockery::mock(ConfigRepository::class);
        $configRepositoryMock->shouldReceive('get')->with('sms.radiation.recipients')
            ->andReturn(['recipient']);
        $configRepositoryMock->shouldReceive('get')->with('sms.radiation.sender_name')
            ->andReturn('notifier');
        $configRepositoryMock->shouldReceive('get')->with('radiation.radiation_background_normal')
            ->andReturn('0.1');
        $notification = new Notification();
        $notification->setContent('translation');
        $notification->setSmsRecipients(['recipient']);
        $notification->setNotifier('notifier');
        $expectedResult = [$notification];
        $cases[] = [$serviceMock, $translatorMock, $configRepositoryMock, $expectedResult];

        /**
         * CASE 1,
         *
         * SCENARIO: radiation info service returns empty response
         *
         * ACTION: not build notification
         */
        $radiationInfo = null;
        $serviceMock = Mockery::mock(RadiationInfoService::class);
        $serviceMock->shouldReceive('getRadiationInfo')->once()->andReturn($radiationInfo);
        $translatorMock = Mockery::mock(Translator::class);
        $configRepositoryMock = Mockery::mock(ConfigRepository::class);
        $expectedResult = [];
        $cases[] = [$serviceMock, $translatorMock, $configRepositoryMock, $expectedResult];

        /**
         * CASE 2,
         *
         * SCENARIO: radiation info service returns radiation info with normal status
         *
         * ACTION: not build notification
         */
        $radiationInfo = new RadiationInfo();
        $radiationInfo->setStatus(RadiationInfo::STATUS_NORMAL);
        $radiationInfo->setRadiationBackground('0.1');
        $radiationInfo->setUpdatedAt('2020-01-01 00:00');
        $serviceMock = Mockery::mock(RadiationInfoService::class);
        $serviceMock->shouldReceive('getRadiationInfo')->andReturn($radiationInfo);
        $translatorMock = Mockery::mock(Translator::class);
        $configRepositoryMock = Mockery::mock(ConfigRepository::class);
        $expectedResult = [];
        $cases[] = [$serviceMock, $translatorMock, $configRepositoryMock, $expectedResult];

        return $cases;
    }

    /**
     * @param  RadiationInfoService  $serviceMock
     * @param  Translator  $translatorMock
     * @param  ConfigRepository  $configRepositoryMock
     * @param  array  $expected
     * @return void
     *
     * @dataProvider dataProvider
     */
    public function testGetNotifications(
        RadiationInfoService $serviceMock,
        Translator $translatorMock,
        ConfigRepository $configRepositoryMock,
        array $expected
    ): void {
        $service = new RadiationInfoNotificationService($serviceMock, $translatorMock, $configRepositoryMock);
        $result = $service->getNotifications();
        self::assertEquals($expected, $result);
    }
}
