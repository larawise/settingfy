<?php

namespace Larawise\Settingfy\Events;

use Srylius\Events\Event;

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
class SettingsDeleted extends Event
{
    /**
     * Create a new event instance.
     *
     * @param array $items
     * @param array $changes
     * @param string $userId
     *
     * @return void
     */
    public function __construct(
        public $items = [],
        public $changes = [],
        public $userId = 'system'
    ) {}
}
