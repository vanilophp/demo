<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        if ('testing' !== app()->environment()) {
            echo("The environment is not testing. I quit. This would likely destroy data.\n");
            exit(1);
        }

        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
            ChromeOptions::CAPABILITY, $options
        )
        );
    }
}
