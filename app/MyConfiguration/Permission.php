<?php

namespace App\MyConfiguration;

use JeroenNoten\LaravelAdminLte\Menu\Filters\FilterInterface;
use Laratrust;

class Permission implements FilterInterface
{
    public function transform($item)
    {
        if (isset($item['permission']) && ! Laratrust::isAbleTo($item['permission'])) {
            $item['restricted'] = true;
        }

        return $item;
    }
}