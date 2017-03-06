<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_group';

    public function user()
    {
        return $this->belongsTo(User::class)->where('active',1);
    }
    public function group()
    {
        return $this->belongsTo(Group::class)->where('active',1);
    }    
}
