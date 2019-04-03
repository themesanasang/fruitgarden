<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Contact  extends Model
{
    use Notifiable;

    protected $table = 'f_contact';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'about', 'phone', 'facebook', 'instagram', 'twitter', 'address'
    ];

}
