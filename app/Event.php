<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Event  extends Model
{
    use Notifiable;

    protected $table = 'f_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'garden_id', 'name', 'detail', 'pic_main_name', 'pic_main_path', 'slug', 'save_user'
    ];

}
