<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    protected $guarded = ['id'];


    //for realtion one to many
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
