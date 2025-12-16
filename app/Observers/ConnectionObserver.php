<?php

namespace App\Observers;

use App\Models\Connection;
use App\Notifications\NewConnectionRequest;

class ConnectionObserver
{
    /**
     * Handle the Connection "created" event.
     */
    public function created(Connection $connection): void
    {
        if ($connection->status === 'pending') {
            $connection->receiver->notify(new NewConnectionRequest($connection->sender));
        }
    }

    /**
     * Handle the Connection "updated" event.
     */
    public function updated(Connection $connection): void
    {
        // Maybe notify on accept?
    }

    /**
     * Handle the Connection "deleted" event.
     */
    public function deleted(Connection $connection): void
    {
        //
    }

    /**
     * Handle the Connection "restored" event.
     */
    public function restored(Connection $connection): void
    {
        //
    }

    /**
     * Handle the Connection "force deleted" event.
     */
    public function forceDeleted(Connection $connection): void
    {
        //
    }
}
