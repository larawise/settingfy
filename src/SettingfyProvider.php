<?php

namespace Larawise\Settingfy;

use Larawise\Packagify\Contracts\DeferrableContract;
use Larawise\Packagify\Packagify;
use Larawise\Packagify\PackagifyProvider;

/**
 * Srylius - The ultimate symphony for technology architecture!
 *
 * @package     Larawise
 * @subpackage  Settingfy
 * @version     v1.0.0
 * @author      Selçuk Çukur <hk@selcukcukur.com.tr>
 * @copyright   Srylius Teknoloji Limited Şirketi
 *
 * @see https://docs.larawise.com/ Larawise : Docs
 */
class SettingfyProvider extends PackagifyProvider
{
    /**
     * Configure the packagify package.
     *
     * @param Packagify $package
     *
     * @return void
     */
    public function configure(Packagify $package)
    {
        $package->name('settingfy')
            ->description('Settingfy - A secure and modular settings manager with encryption, immutability, and database support.')
            ->hasConfigurations()
            ->hasMigrations()
            ->hasHelpers();
    }

    /**
     * Perform actions before the package is registered.
     *
     * @return void
     */
    public function packageRegistering()
    {
        // Register a shared binding in the container.
        $this->app->singleton(
            'settingfy', fn ($app) => new SettingfyManager($app)
        );
    }
}
