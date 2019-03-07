<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'about'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */  
    protected $hidden = [
        'updated_at',
    ];


    /**
     * Get authors associated with this book.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function authors()
    {
        return $this->belongsToMany('App\Author');
    }

    /**
     * Get ids of authors associated with this book.
     *
     * @return array
     */
    public function authorsIds()
    {
        return $this->authors->pluck('id')->toArray();
    }
    
}
