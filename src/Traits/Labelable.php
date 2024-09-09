<?php

namespace Cloudteam\CoreV2\Traits;

trait Labelable
{
    public function badgeLabel($text, $context = 'light-success', $customClass = '', $size = 'badge-lg'): string
    {
        return "<span class='fw-bold badge badge-$context $customClass $size'>$text</span>";
    }

    public function getCreatedAtTextAttribute(): ?string
    {
        return optional($this->created_at)->format(config('core.datetime_format', 'd-m-Y H:i:s'));
    }

    public function getUpdatedAtTextAttribute(): ?string
    {
        return optional($this->updated_at)->format(config('core.datetime_format', 'd-m-Y H:i:s'));
    }

    public function getDeletedAtTextAttribute(): ?string
    {
        return optional($this->deleted_at)->format(config('core.datetime_format', 'd-m-Y H:i:s'));
    }
}
