<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //

    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description',  'status', 'user_id'
    ];

    //for realtion one to many
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
