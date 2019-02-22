<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public function priorities(){
        return $this->belongsToMany('priority','task_priorities','task_id','priority_id');
    }
}
