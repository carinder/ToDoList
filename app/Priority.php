<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $guarded = [];

    public function tasks(){
        return $this->belongsToMany(Task::class);
    }
}
