<?php

namespace Larawise\Settingfy\Drivers;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Query\Builder;
use Larawise\Support\Traits\Connectable;
use Throwable;

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
class DatabaseDriver extends Driver
{
    use Connectable;

    /**
     * The name of the settings table.
     *
     * @var string
     */
    protected $table;

    /**
     * Create a new database setting driver instance.
     *
     * @param ConnectionResolverInterface $db
     * @param Encrypter $encrypter
     * @param Dispatcher $events
     *
     * @return void
     */
    public function __construct($config, $db, $encrypter, $events)
    {
        parent::__construct($config, $encrypter, $events);

        $this->setConnectionResolver($db);
        $this->setConnectionName($this->config('settingfy.connection'));

        $this->table = $this->config('settingfy.table');
    }

    /**
     * Delete settings from storage that are not present in the given items.
     *
     * @param array $items
     *
     * @return void
     */
    protected function delete($items)
    {
        $changes = $this->audit($items);

        foreach ($changes['deleted'] as $key) {
            [$group, $name] = explode('.', $key);

            $this->query()
                ->where('group', $group)
                ->where('key', $name)
                ->delete();
        }
    }

    /**
     * Write settings to the underlying storage.
     *
     * @param array $items
     *
     * @return void
     */
    protected function write($items)
    {
        $changes = $this->audit($items);

        // Handle inserts
        if (! empty($changes['added'])) {
            $inserts = [];

            foreach ($changes['added'] as $key) {
                [$group, $name] = explode('.', $key);

                // Prepare insert payload for each new setting
                $inserts[] = [
                    'group' => $group,
                    'key' => $name,
                    'value' => $items[$group][$name],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Perform bulk insert for newly added settings
            $this->query()->insert($inserts);

            // Dispatch event for created settings
            $this->fireCreatedEvent($items, $changes['added']);
        }

        // Handle updates only if there are any
        if (! empty($changes['updated'])) {
            foreach ($changes['updated'] as $key) {
                [$group, $name] = explode('.', $key);

                // Update existing setting with new value
                $status = $this->query()
                    ->where('group', $group)
                    ->where('key', $name)
                    ->update([
                        'value' => $items[$group][$name],
                        'updated_at' => now(),
                    ]);
            }

            // Dispatch event for updated settings
            $this->fireUpdatedEvent($items, $changes['updated']);
        }
    }

    /**
     * Read settings from the underlying storage.
     *
     * @return array
     */
    protected function read()
    {
        // Only check connection once
        if ($this->connected === null) {
            $this->connected = $this->isConnected();
        }

        // Abort if connection is invalid
        if (! $this->connected) {
            return [];
        }

        // Fetch and parse settings from the database
        return $this->query()
            ->get(['group', 'key', 'value'])
            ->groupBy('group')
            ->map(function ($items) {
                return $items->mapWithKeys(function ($row) {
                    return [$row->key => $row->value];
                })->all();
            })
            ->all();
    }

    /**
     * Get a fresh query builder instance for the table.
     *
     * @return Builder
     */
    protected function query()
    {
        return $this->db()->table($this->table)->useWritePdo();
    }
}
