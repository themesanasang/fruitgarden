<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Picture  extends Model
{
    use Notifiable;

    protected $table = 'f_pictures';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'picture_type', 'use_id', 'pic_name', 'pic_path', 'save_user'
    ];

}
