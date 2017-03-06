<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    /**
     * Get the locations associated with the state.
     */
    public function locations()
    {
        return $this->hasMany(Location::class)->where('active',1);
    }
}
