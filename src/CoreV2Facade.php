<?php

namespace Cloudteam\CoreV2;

use Illuminate\Support\Facades\Facade;

class CoreV2Facade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'core-v2';
    }
}
