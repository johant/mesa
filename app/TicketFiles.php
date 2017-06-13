<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketFiles extends Model
{
    protected $table = 'ticket_files';
    protected $fillable = ['ticket_id', 'filename', 'original_file', 'mime', 'path', 'user_id'];
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
