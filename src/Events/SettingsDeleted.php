<?php

namespace Larawise\Settingfy\Events;

use Illuminate\Contracts\Queue\ShouldQueue;
use Larawise\Events\Event;

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
class SettingsDeleted extends Event implements ShouldQueue
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

    /**
     * Determines whether the event should be queued.
     *
     * @return bool
     */
    public function shouldQueue()
    {
        return config('settingfy.queue.status', $this->shouldQueue);
    }

    /**
     * Defines which queue this event should be dispatched to.
     *
     * @return string
     */
    public function viaQueue()
    {
        return config('settingfy.queue.name', 'settingfy');
    }
}
