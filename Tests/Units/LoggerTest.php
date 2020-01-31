<?php

namespace Tests\Units;


use App\Contracts\LoggerInterface;
use App\Exception\InvalidLogLevelArgument;
use App\Helpers\App;
use App\Logger\Logger;
use App\Logger\LogLevel;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{

    private $logger;

    public function setUp()
    {
        $this->logger = new Logger;
        parent::setUp();
    }

    public function testItImplementsTheLoggerInterface() {
        self::assertInstanceOf(LoggerInterface::class, new Logger());
    }

    public function testItCanCreateDifferentTypesOfLogLevel() {
        $this->logger->info('Testing info logs');
        $this->logger->error('Testing error logs');
        $this->logger->log(LogLevel::ALERT, 'Testing info logs');

        $app = new App;

        $fileName = sprintf("%s/%s-%s.log", $app->getLogPath(), 'test', date('j.n.Y'));

        self::assertFileExists($fileName);

        $contentOfLogFile = file_get_contents($fileName);
        self::assertStringContainsString('Testing info logs', $contentOfLogFile);
        self::assertStringContainsString('Testing error logs', $contentOfLogFile);
        self::assertStringContainsString(LogLevel::ALERT, $contentOfLogFile);
        unlink($fileName);
        self::assertFileNotExists($fileName);

    }

    public function testItThrowsInvalidLogLevelArgumentExceptionWhenGivenAWrongLogLevel() {
        self::expectException(InvalidLogLevelArgument::class);
        $this->logger->log('invalid', 'testing invalid log level');
    }
}