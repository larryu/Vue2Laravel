<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    const ALL= 1;
    const LOCATION = 2;
    const MENU = 3;
    const TAB = 4;
    const PAGE = 5;
    const COMPONENT = 6;
    const PROCESS = 7;
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'resource_types';

}
