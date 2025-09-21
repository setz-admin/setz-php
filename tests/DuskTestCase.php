<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
            '--disable-smooth-scrolling',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        return RemoteWebDriver::create(
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }
     */
    protected function driver(): RemoteWebDriver
    {
        return RemoteWebDriver::create(
            // Change the host from 'localhost:9515' to 'http://selenium:4444/wd/hub'
            'http://selenium:4444/wd/hub',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $this->chromeOptions()
            )
        );
    }
    /**
     * Get the ChromeOptions instance.
     *
     * @return \Facebook\WebDriver\Chrome\ChromeOptions
     */
    protected function chromeOptions()
    {
        return (new ChromeOptions)->addArguments([
            '--window-size=1920,1080',
            '--disable-gpu',
            '--headless=new',
        ]);
    }
}
