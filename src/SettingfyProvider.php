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
        // Set the package name
        $package->name('settingfy');

        // Set the package description
        $package->description('Settingfy - A secure and modular settings manager with encryption, immutability, and database support.');

        // Set the package version
        $package->version('1.0.0');

        // Set the package provideable.
        $package->hasConfigurations();
        $package->hasHelpers();
        $package->hasMigrations();
        $package->hasSingletons([
            'settingfy' => fn ($app) => new SettingfyManager($app)
        ]);
    }
}
