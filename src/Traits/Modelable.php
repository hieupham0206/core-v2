<?php

namespace Cloudteam\CoreV2V2\Traits;

use Illuminate\Support\Str;

trait Modelable
{
    public function getTableNameSingular(): string
    {
        return Str::singular($this->getTable());
    }

    public function canBeCreated(): bool
    {
        $name = $this->getTableNameSingular();

        try {
            return can("create_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function canBeEdited(): bool
    {
        $name = $this->getTableNameSingular();

        try {
            return can("edit_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function canBeDeleted(): bool
    {
        $name = $this->getTableNameSingular();

        try {
            return can("delete_$name");
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCreatedAtFormattedText()
    {
        return optional($this->created_at)->format(config('basecore.datetime_format', 'd-m-Y H:i:s'));
    }

    public function getUpdatedAtText()
    {
        return optional($this->updated_at)->format(config('basecore.datetime_format', 'd-m-Y H:i:s'));
    }

    public function getDescriptionEvent(string $eventName): string
    {
        $displayText = $this->{$this->display};

        if ($this->logAction) {
            $eventName = $this->logAction;
        }
        $user     = auth()->user();
        $username = $user->username ?? 'System';
        $dateTime = now()->format('d-m-Y H:i:s');
        $ip       = request()->getClientIp();

        $subject  = $this->getLogName();
        $action   = "has been {$eventName} by";
        $byObject = "at $dateTime from IP $ip.";

        if ($this->logMessage) {
            return sprintf(
                '%s %s %s %s %s %s',
                $subject,
                $displayText ?? '',
                $action,
                $username,
                $byObject,
                $this->logMessage
            );
        }

        return sprintf('%s %s %s %s %s', $subject, $displayText ?? '', $action, $username, $byObject);
    }
}
