<?php

namespace Cloudteam\CoreV2\Traits;

use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use function get_class;

trait Labelable
{
    public function classLabel($lcfirst = false)
    {
        try {
            $reflect = new ReflectionClass($this);

            if (property_exists(get_class($this), 'logName')) {
                //$nameInModel = $reflect->getStaticPropertyValue('logName');
                $nameInModel = $reflect->getProperty('logName')->getValue($this);
                $tableName   = __($nameInModel);

                if (is_array($tableName)) {
                    $tableName = $nameInModel;
                }

                return $lcfirst ? mb_strtolower($tableName) : $tableName;
            }

            return __(ucfirst(camel2words(Str::studly($reflect->getShortName()))));
        } catch (ReflectionException $e) {
            return '';
        }
    }

    public function badgeLabel($text, $context = 'success', $customClass = '', $size = ''): string
    {
        return "<span class='fw-bold badge badge-$context' $customClass $size>$text</span>";
    }

    public function getModelTitleAttribute(): ?string
    {
        return $this->classLabel(true);
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
