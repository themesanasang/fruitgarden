<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Garden  extends Model
{
    use Notifiable;

    protected $table = 'f_garden';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'detail', 'address', 'phone', 'latlong', 'pic_main_name', 'pic_main_path', 'slug', 'star', 'save_user'
    ];

}
