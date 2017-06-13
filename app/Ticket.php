<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
     //  protected $guarded = [];
    protected $dates = ['published_at'];

    public function getRouteKeyName()
    {
      # code...
      return 'url';
    }

    public function category($value='')
    {
        return $this->belongsTo(Category::class);
        # code...
    }
    public function status($value='')
    {
        return $this->belongsTo(Status::class);
        # code...
    }
    public function user($value='')
    {
        return $this->belongsTo(User::class);
        # code...
    }
    public function tags()
    {
        # code...
        return $this->belongsToMany(Tag::Class);
    }
    public function emails()
    {
        # code...
        return $this->belongsToMany(Email::Class);
    }

    public function scopeUserAction($query)
    {
      if (auth()->user()->role_id != 1){
      $query->where('user_id', auth()->id())
            ->where('status_id', 2)
            ->orderBy('id', 'asc')->get();
      }
      else{
        $query-> where('status_id', 2)
            ->orderBy('id', 'asc')->get();
      }
    }
    public function scopeUserPending($query)
    {
     if (auth()->user()->role_id != 1){
      $query->where('user_id', auth()->id())
            ->whereIn('status_id', array(1, 3, 6))
            ->orderBy('id', 'asc')->get();
       }
      else{
        $query->whereIn('status_id', array(1, 3, 6))
        ->orderBy('id', 'asc')->get();
      }
    }

    public function scopeUserAll($query)
    {
      if (auth()->user()->role_id != 1){
        $query->where('user_id', auth()->id())
        ->orderBy('id', 'asc')->get();
      }
      else{
        $query->orderBy('id', 'asc')->get();
      }
    }
 public function scopeUserStatus($query, $status)
    {
      if (auth()->user()->role_id != 1){
      $query->where('user_id', auth()->id())
            ->where('status_id', $status)
            ->orderBy('id', 'asc')->get();
      }
      else{
        $query-> where('status_id', $status)
            ->orderBy('id', 'asc')->get();
      }

}
}
