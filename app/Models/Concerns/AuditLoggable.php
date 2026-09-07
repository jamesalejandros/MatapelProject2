<?php

namespace App\Models\Concerns;

use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


trait AuditLoggable
{
    use LogsActivity;


    /**
     * ==========================================================
     * ACTIVITY LOG OPTIONS
     * ==========================================================
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()

            /**
             * Log seluruh attribute model.
             */
            ->logAll()

            /**
             * Hanya simpan attribute yang berubah.
             */
            ->logOnlyDirty()

            /**
             * Semua CRUD model masuk ke group "crud".
             */
            ->useLogName('crud');
    }


    /**
     * ==========================================================
     * DESCRIPTION
     * ==========================================================
     */

    public function getDescriptionForEvent(
        string $eventName
    ): string {

        $modelName =
            class_basename($this);


        return match ($eventName) {

            'created' =>
                $modelName . ' dibuat',

            'updated' =>
                $modelName . ' diperbarui',

            'deleted' =>
                $modelName . ' dihapus',

            default =>
                $modelName . ' ' . $eventName,

        };
    }
}
