<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function priorities(){
        return $this->belongsToMany(Priority::class,'tasks_priorities');
    }
}
