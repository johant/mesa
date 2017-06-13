<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
     public function tickets()
    {
        # code...
        return $this->belongsToMany(Ticket::Class);
    }
}
