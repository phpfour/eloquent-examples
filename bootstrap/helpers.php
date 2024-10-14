<?php

use Illuminate\Database\Eloquent\Model;

function logActivity(string $activity, ?Model $subject = null, ?string $channel = null): void
{
    if ($subject instanceof Model) {
        activity($channel)->performedOn($subject)->log($activity);
    } else {
        activity($channel)->log($activity);
    }
}
